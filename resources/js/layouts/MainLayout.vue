<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const leftDrawerOpen = ref(true);

const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value;
};

const logout = () => {
    router.post('/logout');
};
</script>

<template>
  <q-layout view="lHh Lpr lFf" class="bg-grey-1">
    
    <q-header elevated class="bg-white text-grey-9">
      <q-toolbar>
        <q-btn flat dense round icon="menu" aria-label="Menu" @click="toggleLeftDrawer" color="primary" />

        <q-toolbar-title class="row items-center">
          <img 
            src="/img/logo.png" 
            alt="DW Plus Logo"
            style="height: 40px; max-width: 200px; object-fit: contain;" 
          />
          <span class="text-caption q-ml-sm text-grey-7" style="margin-top: 5px; border-left: 1px solid #ccc; padding-left: 8px;">
            Gestão de Patrimônio
          </span>
        </q-toolbar-title>

        <div class="row items-center q-gutter-x-sm">
            <div class="text-caption text-grey-7 gt-xs">
                {{ $page.props.auth?.user?.name || 'Admin' }}
            </div>
            <q-btn flat round dense icon="logout" @click="logout" color="primary">
                <q-tooltip>Sair</q-tooltip>
            </q-btn>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered class="bg-white">
      <q-list padding>
        
        <q-item-label header class="text-weight-bold text-uppercase text-grey-7" style="font-size: 0.75rem;">
          Geral
        </q-item-label>

        <q-item clickable v-ripple @click="router.get('/')" :active="$page.url === '/'">
          <q-item-section avatar>
            <q-icon name="dashboard" color="primary"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Visão Geral</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable v-ripple @click="router.get('/locais')" :active="$page.url.startsWith('/locais')">
          <q-item-section avatar>
            <q-icon name="place" class="text-grey-8"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Locais</q-item-label>
            <q-item-label caption>Agências e Sedes</q-item-label>
          </q-item-section>
        </q-item>

        <q-separator spaced />

        <q-item-label header class="text-weight-bold text-uppercase text-grey-7" style="font-size: 0.75rem;">
          Inventário
        </q-item-label>

        <q-item clickable v-ripple @click="router.get('/equipamentos')" :active="$page.url.startsWith('/equipamentos')">
          <q-item-section avatar>
            <q-icon name="devices" class="text-grey-8"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Patrimônios</q-item-label>
            <q-item-label caption>PCs, Notebooks, Monitores</q-item-label>
          </q-item-section>
        </q-item>

        <q-separator spaced />

        <q-item-label header class="text-weight-bold text-uppercase text-grey-7" style="font-size: 0.75rem;">
          Gestão
        </q-item-label>
        
        <q-item clickable v-ripple>
          <q-item-section avatar>
            <q-icon name="groups" class="text-grey-8"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Colaboradores</q-item-label>
          </q-item-section>
        </q-item>

        <q-separator spaced />

        <q-item-label header class="text-weight-bold text-uppercase text-grey-7" style="font-size: 0.75rem;">
          Suporte
        </q-item-label>

        <q-item 
            clickable 
            v-ripple
            tag="a"
            href="https://dwplus.atlassian.net/servicedesk/customer/portal/11/group/24/create/88"
            target="_blank"
        >
          <q-item-section avatar>
            <q-icon name="confirmation_number" color="negative"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Abrir Tickets</q-item-label>
            <q-item-label caption>Jira Service Desk</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-icon name="open_in_new" size="xs" />
          </q-item-section>
        </q-item>

      </q-list>
    </q-drawer>

    <q-page-container>
      <slot />
    </q-page-container>

  </q-layout>
</template>