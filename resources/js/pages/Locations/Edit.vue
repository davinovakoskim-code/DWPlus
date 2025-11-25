<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';

defineOptions({ layout: MainLayout });
const $q = useQuasar();

const props = defineProps({ location: Object });

const form = useForm({
    name: props.location.name,
    scope: props.location.scope
});

const scopeOptions = ['Interno', 'Externo'];

const submit = () => {
    form.put(`/locais/${props.location.id}`, {
        onSuccess: () => $q.notify({ type: 'positive', message: 'Local atualizado!' })
    });
};
</script>

<template>
    <q-page class="q-pa-md">
        <div class="row items-center justify-between q-mb-md">
            <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Editar Local</h1>
            <q-btn flat color="grey-8" icon="arrow_back" label="Voltar" @click="$inertia.visit('/locais')" />
        </div>

        <q-form @submit.prevent="submit">
            <q-card class="no-shadow" bordered style="max-width: 600px">
                <q-card-section class="q-gutter-y-md">
                    <q-input v-model="form.name" label="Nome do Local *" outlined dense />
                    <q-select v-model="form.scope" :options="scopeOptions" label="Tipo de Local" outlined dense />
                </q-card-section>
                <q-card-actions align="right" class="bg-grey-1">
                    <q-btn label="Atualizar" color="primary" type="submit" :loading="form.processing" icon="save" />
                </q-card-actions>
            </q-card>
        </q-form>
    </q-page>
</template>