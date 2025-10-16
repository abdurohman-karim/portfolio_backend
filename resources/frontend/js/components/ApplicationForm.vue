<!-- Application.vue -->
<script setup>
import { ref, reactive } from "vue";
import axios from "axios";

const form = reactive({
    name: "",
    email: "",
    projectTitle: "",
    description: "",
    budget: "",
    budgetType: "fixed", // fixed | hourly
    deadline: "",
    files: [] // FileList -> array
});

const errors = reactive({
    name: null,
    email: null,
    projectTitle: null,
    description: null,
    budget: null,
    deadline: null,
    server: null
});

const sending = ref(false);
const success = ref(false);
const successMessage = ref("");

function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validate() {
    // сбрасываем ошибки
    Object.keys(errors).forEach(k => (errors[k] = null));
    let ok = true;

    if (!form.name.trim()) {
        errors.name = "Please enter your name";
        ok = false;
    }

    if (!form.email.trim() || !validateEmail(form.email)) {
        errors.email = "Please enter a valid email";
        ok = false;
    }

    if (!form.projectTitle.trim()) {
        errors.projectTitle = "Please enter project title";
        ok = false;
    }

    if (!form.description.trim() || form.description.trim().length < 20) {
        errors.description = "Please describe the project (at least 20 characters)";
        ok = false;
    }

    if (!form.budget || isNaN(form.budget) || Number(form.budget) <= 0) {
        errors.budget = "Please enter a valid budget";
        ok = false;
    }

    if (form.deadline) {
        const d = new Date(form.deadline);
        if (isNaN(d.getTime())) {
            errors.deadline = "Please select a valid date";
            ok = false;
        }
    }

    return ok;
}

function onFilesChange(e) {
    const list = e.target.files;
    // limit total files maybe 5
    const arr = Array.from(list).slice(0, 5);
    form.files = arr;
}

async function submit(e) {
    e && e.preventDefault();
    errors.server = null;
    success.value = false;

    if (!validate()) return;

    sending.value = true;
    try {
        const fd = new FormData();
        fd.append("name", form.name);
        fd.append("email", form.email);
        fd.append("project_title", form.projectTitle);
        fd.append("description", form.description);
        fd.append("budget", form.budget);
        fd.append("budget_type", form.budgetType);
        if (form.deadline) fd.append("deadline", form.deadline);

        form.files.forEach((f, idx) => {
            fd.append(`files[${idx}]`, f);
        });

        const res = await axios.post("/api/applications", fd, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        success.value = true;
        successMessage.value = res?.data?.message || "Application sent successfully";
        form.name = "";
        form.email = "";
        form.projectTitle = "";
        form.description = "";
        form.budget = "";
        form.budgetType = "fixed";
        form.deadline = "";
        form.files = [];

        const fileInput = document.querySelector("#app-files-input");
        if (fileInput) fileInput.value = "";

    } catch (err) {
        console.error(err);
        errors.server =
            err?.response?.data?.error ||
            err?.response?.data?.message ||
            "Server error. Please try again later.";
    } finally {
        sending.value = false;
    }
}
</script>

<template>
    <section class="application-page">
        <div class="container">
            <h1 class="page-title">Order a Project</h1>

            <form class="app-form" @submit="submit" novalidate>
                <div class="row">
                    <label class="field">
                        <span class="label">Your name <span class="req">*</span></span>
                        <input
                            type="text"
                            v-model="form.name"
                            :class="{ invalid: errors.name }"
                            placeholder="John Doe"
                            autocomplete="name"
                        />
                        <div v-if="errors.name" class="error">{{ errors.name }}</div>
                    </label>

                    <label class="field">
                        <span class="label">Email <span class="req">*</span></span>
                        <input
                            type="email"
                            v-model="form.email"
                            :class="{ invalid: errors.email }"
                            placeholder="you@example.com"
                            autocomplete="email"
                        />
                        <div v-if="errors.email" class="error">{{ errors.email }}</div>
                    </label>
                </div>

                <label class="field">
                    <span class="label">Project title <span class="req">*</span></span>
                    <input
                        type="text"
                        v-model="form.projectTitle"
                        :class="{ invalid: errors.projectTitle }"
                        placeholder="Website redesign / Mobile app / E-commerce"
                    />
                    <div v-if="errors.projectTitle" class="error">{{ errors.projectTitle }}</div>
                </label>

                <label class="field">
                    <span class="label">Project description <span class="req">*</span></span>
                    <textarea
                        v-model="form.description"
                        :class="{ invalid: errors.description }"
                        placeholder="Tell us about the goals, target audience, must-have features..."
                        rows="6"
                    ></textarea>
                    <div v-if="errors.description" class="error">{{ errors.description }}</div>
                </label>

                <div class="row">
                    <label class="field small">
                        <span class="label">Budget (USD) <span class="req">*</span></span>
                        <input
                            type="number"
                            v-model="form.budget"
                            :class="{ invalid: errors.budget }"
                            min="0"
                            step="1"
                            placeholder="e.g. 3000"
                        />
                        <div v-if="errors.budget" class="error">{{ errors.budget }}</div>
                    </label>

                    <label class="field small">
                        <span class="label">Type</span>
                        <select v-model="form.budgetType">
                            <option value="fixed">Fixed price</option>
                            <option value="hourly">Hourly rate</option>
                        </select>
                    </label>

                    <label class="field small">
                        <span class="label">Deadline</span>
                        <input type="date" v-model="form.deadline" />
                        <div v-if="errors.deadline" class="error">{{ errors.deadline }}</div>
                    </label>
                </div>

                <label class="field">
                    <span class="label">Attachments (optional, up to 5 files)</span>
                    <input
                        id="app-files-input"
                        type="file"
                        @change="onFilesChange"
                        multiple
                        accept=".png,.jpg,.jpeg,.pdf,.zip,.doc,.docx"
                    />
                    <small class="hint">Allowed: images, pdf, doc, zip — max 5 files</small>
                </label>

                <div class="actions">
                    <button
                        type="submit"
                        class="application_button"
                        :disabled="sending"
                        aria-busy="sending"
                    >
                        <span v-if="!sending">Send Application</span>
                        <span v-else>Sending...</span>
                    </button>
                    <router-link to="/" class="application_back">Back to home</router-link>
                </div>

                <div v-if="errors.server" class="server-error">{{ errors.server }}</div>
                <div v-if="success" class="success">
                    {{ successMessage }}
                </div>
            </form>
        </div>
    </section>
</template>

<style scoped>
.application-page {
    padding-top: 100px;
    margin-bottom: 100px;
    font-family: UbuntuMedium;
}

/* simple layout */
.page-title {
    color: var(--text-dark);
    font-size: 2rem;
    margin-bottom: 1.25rem;
    text-align: center;
}

/* fields */
.app-form .row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.field {
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;
    width: 100%;
}

.field.small {
    width: 32%;
    min-width: 180px;
}

.label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.req {
    color: var(--error-color);
    margin-left: 0.25rem;
}

/* inputs */
input[type="text"],
input[type="email"],
input[type="number"],
input[type="date"],
select,
textarea {
    color: var(--text-dark);
    border: none;
    border-radius: 8px;
    padding: 0.8rem 0.75rem;
    font-size: 1rem;
    outline: none;
    transition: box-shadow .15s, border-color .15s;
    background: var(--light-blug);
}

input:focus,
textarea:focus,
select:focus {
    box-shadow: 0 4px 18px rgba(23, 43, 77, 0.06);
    border-color: rgba(37,99,235,0.6);
}

textarea {
    resize: vertical;
    min-height: 140px;
}

/* errors */
.error {
    color: var(--error-color);
    font-size: 0.9rem;
    margin-top: 0.35rem;
}

.server-error {
    margin-top: 1rem;
    color: var(--error-color);
}

/* success */
.success {
    margin-top: 1rem;
    color: var(--success-color);
    background: rgba(15,81,50,0.06);
    padding: 0.6rem 0.9rem;
    border-radius: 6px;
}

/* hint */
.hint {
    display: block;
    margin-top: 0.4rem;
    color: var(--text-dark);
    font-size: 0.9rem;
}

/* hero button (simple) */
.application_button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-top: 30px;
    padding: 0.8rem 1.25rem;
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 700;
    font-size: 1rem;
    transition: 0.3s ease;
    text-decoration: none;
    &:hover{
        transform: translateY(-2px);
        background: var(--primary-dark);
    }
}
.application_back {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-top: 30px;
    margin-left: 20px;
    padding: 0.8rem 1.25rem;
    background: var(--dark-blug);
    color: #fff;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 700;
    font-size: 1rem;
    transition: 0.3s ease;
    text-decoration: none;
    &:hover{
        transform: translateY(-2px);
        background: var(--icon);
    }
}

.application_button[disabled] {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

/* responsive */
@media (max-width: 720px) {
    .field.small {
        width: 100%;
    }
    .app-form .row { gap: .5rem; }
}
</style>
