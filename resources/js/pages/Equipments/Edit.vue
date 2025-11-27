<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { useForm, router } from '@inertiajs/vue3'; 
import { useQuasar } from 'quasar';
import { computed } from 'vue';

defineOptions({ layout: MainLayout });

const $q = useQuasar();

const props = defineProps({
    equipment: Object,
    locations: Array,
    departments: Array,
    groups: Array,
    subgroups: Array
});


const form = useForm({
    _method: 'put', 
    asset_code: props.equipment.asset_code,
    name: props.equipment.name,
    description: props.equipment.description,
    location_id: props.equipment.location_id,
    department_id: props.equipment.department_id,
    group_id: props.equipment.group_id,
    subgroup_id: props.equipment.subgroup_id,
    status: props.equipment.status,
    attachment_filename: null,
    is_rented: Boolean(props.equipment.is_rented)
});

const statusOptions = ['Disponível', 'Em Uso', 'Manutenção', 'Baixado'];

const filteredSubgroups = computed(() => {
    if (!form.group_id) return props.subgroups;
    return props.subgroups.filter(sub => sub.group_id === form.group_id);
});

const submit = () => {
    
    form.post(`/equipamentos/${props.equipment.id}`, {
        forceFormData: true,
        onSuccess: () => {
            $q.notify({ type: 'positive', message: 'Patrimônio atualizado com sucesso!' });
        },
        onError: () => {
            $q.notify({ type: 'negative', message: 'Erro ao atualizar. Verifique os campos.' });
        }
    });
};
</script>

<template>
    <q-page class="q-pa-md">
        <div class="row items-center justify-between q-mb-md">
            <div>
                <h1 class="text-h5 text-grey-9 q-my-none text-weight-bold">Editar Patrimônio</h1>
                <div class="text-grey-7">Alterar dados do ativo: {{ form.asset_code }}</div>
            </div>
            <q-btn flat color="grey-8" icon="arrow_back" label="Voltar" @click="$inertia.visit('/equipamentos')" />
        </div>

        <q-form @submit.prevent="submit">
            <q-card class="no-shadow" bordered>
                <q-card-section class="q-pa-lg">
                    <div class="text-subtitle1 text-weight-bold text-primary q-mb-md">Informações Principais</div>
                    <div class="row q-col-gutter-md">
                        <div class="col-12 col-md-4">
                            <q-input v-model="form.asset_code" label="Código do Patrimônio *" outlined dense :error="!!form.errors.asset_code" :error-message="form.errors.asset_code">
                                <template v-slot:prepend><q-icon name="qr_code" /></template>
                            </q-input>
                        </div>
                        <div class="col-12 col-md-8">
                            <q-input v-model="form.name" label="Nome do Equipamento *" outlined dense :error="!!form.errors.name" :error-message="form.errors.name">
                                <template v-slot:prepend><q-icon name="devices" /></template>
                            </q-input>
                        </div>
                        <div class="col-12">
                            <q-input v-model="form.description" label="Descrição Detalhada" outlined dense type="textarea" rows="3" />
                        </div>
                    </div>

                    <q-separator class="q-my-lg" />
                    <div class="text-subtitle1 text-weight-bold text-primary q-mb-md">Classificação</div>

                    <div class="row q-col-gutter-md">
                        <div class="col-12 col-md-6">
                            <q-select v-model="form.location_id" :options="locations" label="Local Físico" outlined dense emit-value map-options option-label="name" option-value="id">
                                <template v-slot:option="scope">
                                    <q-item v-bind="scope.itemProps">
                                        <q-item-section>
                                            <q-item-label>{{ scope.opt.name }}</q-item-label>
                                            <q-item-label caption>{{ scope.opt.scope }}</q-item-label>
                                        </q-item-section>
                                    </q-item>
                                </template>
                                <template v-slot:prepend><q-icon name="place" /></template>
                            </q-select>
                        </div>
                        <div class="col-12 col-md-6">
                            <q-select v-model="form.department_id" :options="departments" label="Departamento" outlined dense emit-value map-options option-label="name" option-value="id">
                                <template v-slot:prepend><q-icon name="business" /></template>
                            </q-select>
                        </div>
                        <div class="col-12 col-md-6">
                            <q-select v-model="form.group_id" :options="groups" label="Grupo" outlined dense emit-value map-options option-label="name" option-value="id" @update:model-value="form.subgroup_id = null">
                                <template v-slot:prepend><q-icon name="folder" /></template>
                            </q-select>
                        </div>
                        <div class="col-12 col-md-6">
                            <q-select v-model="form.subgroup_id" :options="filteredSubgroups" label="Subgrupo" outlined dense emit-value map-options option-label="name" option-value="id" :disable="!form.group_id">
                                <template v-slot:prepend><q-icon name="category" /></template>
                            </q-select>
                        </div>
                        <div class="col-12 col-md-6">
                            <q-select v-model="form.status" :options="statusOptions" label="Status Atual" outlined dense>
                                <template v-slot:prepend><q-icon name="info" /></template>
                            </q-select>
                        </div>
                    </div>

                    <q-separator class="q-my-lg" />
                    <div class="row q-col-gutter-md items-center">
                        <div class="col-12 col-md-8">
                            <q-file v-model="form.attachment_filename" label="Alterar Imagem (Opcional)" outlined dense bottom-slots>
                                <template v-slot:prepend><q-icon name="attach_file" /></template>
                                <template v-slot:hint>Deixe vazio para manter a atual</template>
                            </q-file>
                        </div>
                        <div class="col-12 col-md-4">
                            <q-toggle v-model="form.is_rented" label="Equipamento Alugado?" color="primary" left-label />
                        </div>
                    </div>
                </q-card-section>

                <q-separator />
                <q-card-actions align="right" class="q-pa-md bg-grey-1">
                    <q-btn flat label="Cancelar" color="grey-8" @click="$inertia.visit('/equipamentos')" />
                    <q-btn label="Salvar Alterações" color="primary" type="submit" :loading="form.processing" icon="save" />
                </q-card-actions>
            </q-card>
        </q-form>
    </q-page>
</template>