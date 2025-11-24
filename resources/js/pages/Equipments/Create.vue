<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useQuasar } from 'quasar';

defineOptions({ layout: MainLayout });

const $q = useQuasar();

// Props vindas do Controller (Listas para os Selects)
// Por enquanto virão vazias, então coloquei opções manuais de teste
const props = defineProps({
    locations: Array,
    departments: Array,
    subgroups: Array
});

// Formulário do Inertia
const form = useForm({
    asset_code: '',
    name: '',
    description: '',
    location_id: null,
    department_id: null,
    subgroup_id: null,
    status: 'Disponível',
    attachment_filename: null,
    rented: false
});

// Opções estáticas para testar o visual (enquanto não puxamos do banco)
const statusOptions = ['Disponível', 'Em Uso', 'Manutenção', 'Baixado'];
// Mockando dados para você ver como fica o Select preenchido
const mockLocations = [{ label: 'Sala TI (Térreo)', value: 1 }, { label: 'Recepção', value: 2 }];
const mockDepartments = [{ label: 'Administrativo', value: 1 }, { label: 'Comercial', value: 2 }];
const mockSubgroups = [{ label: 'Notebooks', value: 1 }, { label: 'Periféricos', value: 2 }];

const submit = () => {
    form.post('/equipamentos', {
        onSuccess: () => {
            $q.notify({
                type: 'positive',
                message: 'Equipamento cadastrado com sucesso!'
            });
        },
        onError: () => {
            $q.notify({
                type: 'negative',
                message: 'Verifique os campos obrigatórios.'
            });
        }
    });
};
</script>

<template>
    <q-page class="q-pa-md">
        
        <div class="row items-center justify-between q-mb-md">
            <div>
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Novo Equipamento</h1>
                <div class="text-grey-7">Preencha os dados do ativo</div>
            </div>
            <q-btn flat color="grey-8" icon="arrow_back" label="Voltar" @click="$inertia.visit('/equipamentos')" />
        </div>

        <q-form @submit.prevent="submit">
            <q-card class="no-shadow" bordered>
                <q-card-section class="q-pa-lg">
                    
                    <div class="text-subtitle1 text-weight-bold text-primary q-mb-md">Informações Principais</div>
                    
                    <div class="row q-col-gutter-md">
                        <div class="col-12 col-md-4">
                            <q-input 
                                v-model="form.asset_code" 
                                label="Código do Patrimônio *" 
                                outlined dense
                                placeholder="Ex: DW-0001"
                                :error="!!form.errors.asset_code"
                                :error-message="form.errors.asset_code"
                            >
                                <template v-slot:prepend><q-icon name="qr_code" /></template>
                            </q-input>
                        </div>

                        <div class="col-12 col-md-8">
                            <q-input 
                                v-model="form.name" 
                                label="Nome do Equipamento *" 
                                outlined dense
                                placeholder="Ex: Notebook Dell Latitude 5420"
                                :error="!!form.errors.name"
                                :error-message="form.errors.name"
                            >
                                <template v-slot:prepend><q-icon name="devices" /></template>
                            </q-input>
                        </div>

                        <div class="col-12">
                            <q-input 
                                v-model="form.description" 
                                label="Descrição Detalhada" 
                                outlined dense type="textarea" rows="3"
                                placeholder="Detalhes técnicos, processador, memória, observações..."
                            />
                        </div>
                    </div>

                    <q-separator class="q-my-lg" />

                    <div class="text-subtitle1 text-weight-bold text-primary q-mb-md">Localização e Categoria</div>

                    <div class="row q-col-gutter-md">
                        <div class="col-12 col-md-6">
                            <q-select 
                                v-model="form.location_id" 
                                :options="mockLocations"
                                label="Local Físico" 
                                outlined dense emit-value map-options
                            >
                                <template v-slot:prepend><q-icon name="place" /></template>
                            </q-select>
                        </div>

                        <div class="col-12 col-md-6">
                            <q-select 
                                v-model="form.department_id" 
                                :options="mockDepartments"
                                label="Setor / Departamento" 
                                outlined dense emit-value map-options
                            >
                                <template v-slot:prepend><q-icon name="business" /></template>
                            </q-select>
                        </div>

                        <div class="col-12 col-md-6">
                            <q-select 
                                v-model="form.subgroup_id" 
                                :options="mockSubgroups"
                                label="Grupo / Categoria" 
                                outlined dense emit-value map-options
                            >
                                <template v-slot:prepend><q-icon name="category" /></template>
                            </q-select>
                        </div>

                        <div class="col-12 col-md-6">
                            <q-select 
                                v-model="form.status" 
                                :options="statusOptions"
                                label="Status Atual" 
                                outlined dense
                            >
                                <template v-slot:prepend><q-icon name="info" /></template>
                            </q-select>
                        </div>
                    </div>

                    <q-separator class="q-my-lg" />

                    <div class="text-subtitle1 text-weight-bold text-primary q-mb-md">Outros</div>

                    <div class="row q-col-gutter-md items-center">
                        <div class="col-12 col-md-8">
                            <q-file 
                                v-model="form.attachment_filename" 
                                label="Anexar Imagem ou Documento" 
                                outlined dense
                                counter
                                max-files="1"
                            >
                                <template v-slot:prepend><q-icon name="attach_file" /></template>
                            </q-file>
                        </div>

                        <div class="col-12 col-md-4">
                            <q-toggle 
                                v-model="form.rented" 
                                label="Este equipamento é alugado?" 
                                color="primary"
                                left-label
                            />
                        </div>
                    </div>

                </q-card-section>

                <q-separator />

                <q-card-actions align="right" class="q-pa-md bg-grey-1">
                    <q-btn flat label="Cancelar" color="grey-8" @click="$inertia.visit('/equipamentos')" />
                    <q-btn 
                        label="Confirmar Cadastro" 
                        color="primary" 
                        type="submit" 
                        :loading="form.processing"
                        icon="check"
                        padding="8px 20px"
                    />
                </q-card-actions>
            </q-card>
        </q-form>

    </q-page>
</template>