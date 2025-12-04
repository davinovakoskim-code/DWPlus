<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';

defineOptions({ layout: MainLayout });
const $q = useQuasar();

const props = defineProps({ locations: Array });

const columns = [
  { name: 'name', align: 'left', label: 'Nome do Local', field: 'name', sortable: true },
  { name: 'scope', align: 'left', label: 'Tipo', field: 'scope', sortable: true },
  { name: 'actions', align: 'right', label: 'Ações' }
];

const deleteItem = (id) => {
    $q.dialog({
        title: 'Excluir Local',
        message: 'Tem certeza? Isso não apagará os equipamentos vinculados, mas deixará eles sem local.',
        cancel: true,
        persistent: true
    }).onOk(() => {
        router.delete(`/locais/${id}`);
    });
};
</script>

<template>
    <Head title="Gestão de Locais" />

    <q-page class="q-pa-md">
        <div class="row items-center justify-between q-mb-md">
            <div>
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Gestão de Locais</h1>
                <div class="text-grey-7">Agências e Sedes</div>
            </div>
            <q-btn color="primary" icon="add" label="Novo Local" @click="router.get('/locais/criar')" />
        </div>

        <q-card class="no-shadow" bordered>
            <div class="scroll-container">
                <q-table
                    flat
                    :rows="locations"
                    :columns="columns"
                    row-key="id"
                    :pagination="{ rowsPerPage: 25 }" >
                    
                    <template v-slot:body-cell-scope="props">
                        <q-td :props="props">
                            <q-badge :color="props.row.scope === 'Interno' ? 'blue-7' : 'orange-8'" :label="props.row.scope" />
                        </q-td>
                    </template>

                    <template v-slot:body-cell-actions="props">
                        <q-td :props="props">
                            <q-btn flat round color="grey-7" icon="edit" size="sm" @click="router.get(`/locais/${props.row.id}/editar`)" />
                            <q-btn flat round color="negative" icon="delete" size="sm" @click="deleteItem(props.row.id)" />
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


.scroll-container::-webkit-scrollbar {
  width: 8px;
}

.scroll-container::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.scroll-container::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 4px;
}

.scroll-container::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}
</style>