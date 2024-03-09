<template>
    <div class="flex flex-col w-full">
        <div class="flex justify-between text-sm text-gray-500">
            <span>Kirjoittaja: {{ article.user.name }}</span>
            <span v-if="article.multi"
                >Viimeisin muokkaaja:
                {{ article.updater.name.split(" ")[0] }}</span
            >
        </div>
        <h1
            class="text-2xl w-full p-8 flex justify-around items-center border bg-white"
        >
            <span>{{ article.title }}</span>

            <div v-if="editable" class="flex gap-4">
                <span
                    class="hover:text-blue-500 cursor-pointer"
                    @click="edit(article.id)"
                    >🖉</span
                >
                <span
                    class="hover:text-blue-500 cursor-pointer"
                    @click="confirmArticleDeletion"
                    >🗑</span
                >
                <Modal :show="confirmingArticleDeletion" @close="closeModal">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Haluatko poistaa artikkelin?
                        </h2>

                        <div class="mt-6">
                            <InputLabel
                                for="password"
                                value="Salasana"
                                class="sr-only"
                            />

                            <TextInput
                                id="password"
                                ref="passwordInput"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-3/4"
                                placeholder="Password"
                                @keyup.enter="deleteArticle"
                            />

                            <InputError
                                :message="form.errors.password"
                                class="mt-2"
                            />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeModal">
                                Peruuta
                            </SecondaryButton>

                            <DangerButton
                                class="ms-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click="deleteArticle"
                            >
                                Poista artikkeli
                            </DangerButton>
                        </div>
                    </div>
                </Modal>
            </div>
        </h1>
        <div
            v-html="md.render(article.content)"
            class="bg-white p-4 markdown"
        ></div>
        <div class="flex gap-4 mt-2">
            <TagBadge v-for="tag in article.tags" :tag="tag" />
            <TagPicker v-if="editable" />
        </div>
        <div class="flex justify-between text-sm text-gray-500">
            <span>Julkaistu: {{ published }}</span>
            <span>Päivitetty: {{ updated }}</span>
        </div>
    </div>
</template>
<script setup lang="ts">
import { computed } from "vue";
import { Article } from "../types";

import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TagBadge from "@/Components/TagBadge.vue";
import TagPicker from "@/Components/TagPicker.vue";

import { useForm, router } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import markdownit from "markdown-it";

const confirmingArticleDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const props = defineProps<{
    article: Article;
    editable: boolean;
}>();

const md = markdownit();

const published = computed(() => {
    return new Date(props.article.created_at).toLocaleString("fi-fi");
});
const updated = computed(() => {
    return new Date(props.article.updated_at).toLocaleString("fi-fi");
});

const form = useForm({
    password: "",
});

const confirmArticleDeletion = () => {
    confirmingArticleDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteArticle = () => {
    form.delete(route("articles.destroy", { article: props.article.id }), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingArticleDeletion.value = false;

    form.reset();
};

const edit = (id: number) => {
    router.get("/articles/" + id + "/edit");
};
</script>

<style lang="postcss">
.markdown > h1 {
    @apply text-2xl mb-2;
}
.markdown > h2 {
    @apply text-xl mb-2;
}

.markdown > h3 {
    @apply text-lg mb-2;
}
.markdown > p {
    margin-bottom: 0.25rem;
    text-indent: 2rem;
}
.markdown > p:first-of-type {
    text-indent: 0rem;
}
.markdown > ul > li::before {
    content: " - ";
}
.markdown > ul > li {
    text-indent: 2rem;
}
</style>
