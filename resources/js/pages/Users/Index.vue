<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';
import { computed } from 'vue';

defineOptions({ layout: MainLayout });
const $q = useQuasar();
const page = usePage();

const props = defineProps({ users: Array });


const currentUser = computed(() => page.props.auth.user);

const columns = [
  { name: 'name', align: 'left', label: 'Nome', field: 'name', sortable: true },
  { name: 'email', align: 'left', label: 'E-mail', field: 'email', sortable: true },
  { name: 'created_at', align: 'left', label: 'Data de Cadastro', field: row => new Date(row.created_at).toLocaleDateString('pt-BR'), sortable: true },
  { name: 'actions', align: 'right', label: 'Ações' }
];

const deleteItem = (id) => {
    $q.dialog({
        title: 'Excluir Usuário',
        message: 'Tem certeza que deseja excluir este usuário? Essa ação não pode ser desfeita.',
        cancel: true,
        persistent: true,
        ok: { label: 'Excluir', color: 'negative', flat: true },
        cancel: { label: 'Cancelar', color: 'grey-8', flat: true }
    }).onOk(() => {
        router.delete(`/usuarios/${id}`);
    });
};
</script>

<template>
    <Head title="Colaboradores" />

    <q-page class="q-pa-md">
        <div class="row items-center justify-between q-mb-md">
            <div>
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Colaboradores</h1>
                <div class="text-grey-7">Gerencie os usuários do sistema</div>
            </div>
            <q-btn color="primary" icon="add" label="Novo Usuário" @click="router.get('/usuarios/criar')" />
        </div>

        <q-card class="no-shadow" bordered>
            <div class="scroll-container">
                <q-table
                    flat
                    :rows="users"
                    :columns="columns"
                    row-key="id"
                    :pagination="{ rowsPerPage: 10 }"
                >
                    <template v-slot:body-cell-actions="props">
                        <q-td :props="props">

                            <q-btn
                                v-if="props.row.id !== currentUser?.value?.id"
                                flat
                                round
                                color="negative"
                                icon="delete"
                                size="sm"
                                @click="deleteItem(props.row.id)"
                            >
                                <q-tooltip>Excluir Usuário</q-tooltip>
                            </q-btn>

                            <q-chip
                                v-else
                                dense
                                color="primary"
                                text-color="white"
                                size="sm"
                                icon="person"
                            >
                                Você
                            </q-chip>

                        </q-td>
                    </template>
                </q-table>
            </div>
        </q-card>
    </q-page>
</template>

<style scoped>
.scroll-container {
  height: calc(100vh - 200px);
  overflow-y: auto;
}
</style>