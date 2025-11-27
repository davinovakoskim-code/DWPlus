<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';

defineOptions({ layout: MainLayout });
const $q = useQuasar();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/usuarios', {
        onSuccess: () => {
            $q.notify({ type: 'positive', message: 'Usuário criado com sucesso!' });
        },
        onError: () => {
            $q.notify({ type: 'negative', message: 'Erro ao criar usuário. Verifique os campos.' });
        },
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <q-page class="q-pa-md">
        <div class="row items-center justify-between q-mb-md">
            <div>
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Novo Colaborador</h1>
                <div class="text-grey-7">Cadastre um novo usuário no sistema</div>
            </div>
            <q-btn flat color="grey-8" icon="arrow_back" label="Voltar" @click="router.get('/usuarios')" />
        </div>

        <q-form @submit.prevent="submit">
            <q-card class="no-shadow" bordered style="max-width: 600px;">
                <q-card-section class="q-pa-lg q-gutter-y-md">
                    <q-input
                        v-model="form.name"
                        label="Nome Completo *"
                        outlined dense
                        :error="!!form.errors.name"
                        :error-message="form.errors.name"
                    >
                        <template v-slot:prepend><q-icon name="person" /></template>
                    </q-input>

                    <q-input
                        v-model="form.email"
                        label="E-mail *"
                        type="email"
                        outlined dense
                        :error="!!form.errors.email"
                        :error-message="form.errors.email"
                    >
                        <template v-slot:prepend><q-icon name="email" /></template>
                    </q-input>

                    <q-input
                        v-model="form.password"
                        label="Senha *"
                        type="password"
                        outlined dense
                        :error="!!form.errors.password"
                        :error-message="form.errors.password"
                    >
                        <template v-slot:prepend><q-icon name="lock" /></template>
                    </q-input>

                    <q-input
                        v-model="form.password_confirmation"
                        label="Confirmar Senha *"
                        type="password"
                        outlined dense
                        :error="!!form.errors.password_confirmation"
                        :error-message="form.errors.password_confirmation"
                    >
                        <template v-slot:prepend><q-icon name="lock_clock" /></template>
                    </q-input>
                </q-card-section>

                <q-separator />
                <q-card-actions align="right" class="q-pa-md bg-grey-1">
                    <q-btn flat label="Cancelar" color="grey-8" @click="router.get('/usuarios')" />
                    <q-btn label="Cadastrar Usuário" color="primary" type="submit" :loading="form.processing" icon="save" />
                </q-card-actions>
            </q-card>
        </q-form>
    </q-page>
</template>