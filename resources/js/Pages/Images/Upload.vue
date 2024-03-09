<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, usePage, Head } from "@inertiajs/vue3";

const form = useForm({
    image: null,
    desc: "",
});
const submit = () => {
    alert(JSON.stringify(form));
    form.post(route("images.store"));
};
</script>

<template>
    <MainLayout>
        <div class="flex flex-col">
            <form @submit.prevent="submit">
                <InputLabel for="desc" value="Kuvaus" />

                <TextInput
                    id="desc"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.desc"
                    required
                    autofocus
                />
                <label
                    for="file"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    >Tiedosto
                </label>
                <span>{{ JSON.stringify(form.image) }}</span>
                <input
                    id="file"
                    type="file"
                    accept="image/*"
                    @input="form.image = $event.target.files[0]"
                    name="image"
                    style="display: none"
                />
                <PrimaryButton :disabled="form.processing"
                    >Lähetä</PrimaryButton
                >
            </form>
        </div>
    </MainLayout>
</template>
