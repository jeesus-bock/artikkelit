<template>
    <MainLayout>
        <Head :title="article ? 'Muokkaa' : 'Uusi'" />
        <section class="w-full p-8 h-full flex-grow">
            <form @submit.prevent="submit" class="mt-6 space-y-6 h-full block">
                <div>
                    <InputLabel for="title" value="Otsikko" />

                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus
                    />

                    <InputError class="mt-2" :message="form.errors.title" />
                </div>
                <div>
                    <label class="flex items-center">
                        <CheckBox name="draft" v-model:checked="form.draft" />
                        <span class="ms-2 text-sm text-gray-600">Luonnos</span>
                    </label>
                    <label class="flex items-center">
                        <CheckBox name="multi" v-model:checked="form.multi" />
                        <span class="ms-2 text-sm text-gray-600"
                            >Vapaasti muokattavissa</span
                        >
                    </label>
                </div>
                <div>
                    <InputLabel for="content" value="Sisältö" />

                    <textarea
                        id="content"
                        class="mt-1 block w-full h-96"
                        v-model="form.content"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.content" />
                </div>
                <div>
                    <TagPicker />
                </div>
                <div class="flex items-center gap-4">
                    <PrimaryButton :disabled="form.processing"
                        >Tallenna</PrimaryButton
                    >

                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p
                            v-if="form.recentlySuccessful"
                            class="text-sm text-gray-600"
                        >
                            Tallennettu.
                        </p>
                    </Transition>
                </div>
            </form>
        </section>
    </MainLayout>
</template>

<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import CheckBox from "@/Components/CheckBox.vue";
import TagPicker from "@/Components/TagPicker.vue";
import { useForm, usePage, Head } from "@inertiajs/vue3";
import { Article } from "@/types";
import { onUnmounted } from "vue";
const props = defineProps<{
    article?: Article;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    title: props.article?.title || "",
    content: props.article?.content || "",
    draft: props.article?.draft || true,
    multi: props.article?.multi || false,
});
const submit = () => {
    if (props.article) {
        form.put(route("articles.update", { article: props.article.id }));
    } else {
        form.post(route("articles.store"));
    }
};
onUnmounted(() => {
    alert("pösilö");
});
</script>
