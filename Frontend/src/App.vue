<script setup >
  import TodoApp from './components/TodoApp.vue'  
  import '@fortawesome/fontawesome-free/css/all.min.css'
</script>

<template>
    <TodoApp />
</template>

<style>
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
  }

  #app {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #bec0c4;
  }

</style>