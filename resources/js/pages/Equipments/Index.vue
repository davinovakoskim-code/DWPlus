<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useQuasar } from 'quasar';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'; // <--- CORREÇÃO 1: Importar o router

// Define que usa o layout principal
defineOptions({ layout: MainLayout });

// Recebe os dados do Laravel
const props = defineProps({
    equipments: Array
});

// Configuração das colunas IGUAL ao Banco de Dados
const columns = [
  { name: 'asset_code', align: 'left', label: 'Cód. Patrimônio', field: 'asset_code', sortable: true },
  { name: 'name', align: 'left', label: 'Nome do Equipamento', field: 'name', sortable: true },
  { name: 'location_id', align: 'left', label: 'Local (ID)', field: 'location_id', sortable: true },
  { name: 'status', align: 'center', label: 'Status', field: 'status', sortable: true },
  { name: 'actions', align: 'right', label: 'Ações' }
];

// Função para definir cor do status
const getStatusColor = (status) => {
    if (status === 'Em Uso') return 'positive';
    if (status === 'Disponível') return 'warning';
    if (status === 'Manutenção') return 'negative';
    return 'grey';
};
</script>

<template>
    <q-page class="q-pa-md">
        
        <div class="row items-center justify-between q-mb-md">
            <div>
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Equipamentos</h1>
                <div class="text-grey-7">Gerencie o inventário de ativos</div>
            </div>
            
            <q-btn 
                color="primary" 
                icon="add" 
                label="Novo Equipamento" 
                @click="router.get('/equipamentos/criar')"
            />
        </div>

        <q-card class="no-shadow" bordered>
            <q-table
                flat
                :rows="equipments"
                :columns="columns"
                row-key="id"
                :pagination="{ rowsPerPage: 10 }"
            >
                <template v-slot:body-cell-status="props">
                    <q-td :props="props">
                        <q-chip 
                            :color="getStatusColor(props.row.status)" 
                            text-color="white" 
                            dense 
                            size="sm"
                        >
                            {{ props.row.status || 'Sem Status' }}
                        </q-chip>
                    </q-td>
                </template>

                <template v-slot:body-cell-actions="props">
                    <q-td :props="props">
                        <q-btn flat round color="grey-7" icon="edit" size="sm">
                            <q-tooltip>Editar</q-tooltip>
                        </q-btn>
                        <q-btn flat round color="negative" icon="delete" size="sm">
                            <q-tooltip>Excluir</q-tooltip>
                        </q-btn>
                    </q-td>
                </template>

            </q-table>
        </q-card>

    </q-page>
</template>