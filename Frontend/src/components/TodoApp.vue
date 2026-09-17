<script setup>
import { onMounted, computed } from 'vue'
import { useTodoStore } from '../stores/todoStore.ts'
import TodoInput from './TodoInput.vue'
import TodoItem from './TodoItem.vue'

const store = useTodoStore()

onMounted(() => {
  store.fetchTodos()
})

const handleAddTodo = async (title) => {
  try {
    await store.addTodo(title)
  } catch (error) {
    console.error('Erreur:', error)
  }
}

const handleToggleTodo = (id) => {
  store.toggleTodo(id)
}

const handleDeleteTodo = (id) => {
  store.deleteTodo(id)
}

const completedCount = computed(() => {
  return store.todos.filter((todo) => todo.is_completed).length
})

const progressPercentage = computed(() => {
  if (store.todos.length === 0) return 0
  return Math.round((completedCount.value / store.todos.length) * 100)
})
</script>

<template>
  <div class="todo-app">
    <div class="container">
      <header class="header">
        <h1>Dynamic Todo App <i class="fa-solid fa-rocket"></i></h1>
      </header>

      <div class="main-controls">
        <div class="input-section">
          <TodoInput @add-todo="handleAddTodo" />
        </div>

        <div class="filters-section">
          <div class="controls">
            <div class="filter-buttons">
              <button @click="store.filter = 'all'" :class="{ active: store.filter === 'all' }">
                All ({{ store.todos.length }})
              </button>
              <button
                @click="store.filter = 'active'"
                :class="{ active: store.filter === 'active' }"
              >
                Active ({{ store.remainingCount }})
              </button>
              <button
                @click="store.filter = 'completed'"
                :class="{ active: store.filter === 'completed' }"
              >
                Completed ({{ completedCount }})
              </button>
            </div>

            <div>
              <div class="progress-header">
                <div class="progress-percentage">{{ progressPercentage }}%</div>
              </div>

              <div class="progress-bar-container">
                <div class="progress-bar">
                  <div class="progress-fill" :style="{ width: progressPercentage + '%' }"></div>
                </div>
              </div>

              <div class="progress-footer">{{ store.remainingCount }} tasks remaning</div>
            </div>
          </div>
        </div>
      </div>

      <div v-if="store.loading" class="loading-section">
        <div class="spinner"></div>
        <p>Loading tasks...</p>
      </div>

      <div v-if="store.error" class="error-message">
        <i class="fas fa-exclamation-triangle"></i> {{ store.error }}
      </div>

      <!-- Liste des tâches -->
      <div class="todo-list-container">
        <div v-if="store.filteredTodos.length === 0" class="empty-state">
          <p><i class="fas fa-inbox"></i> No tasks to show</p>
          <p v-if="store.filter !== 'all'">Try changing the filter or add a new task.</p>
        </div>

        <div v-else class="todo-list">
          <TodoItem
            v-for="todo in store.filteredTodos"
            :key="todo.id"
            :todo="todo"
            @toggle="handleToggleTodo"
            @delete="handleDeleteTodo"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.todo-app {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
}

.container {
  background: #e7eaee;
  border-radius: 15px;
  box-shadow: 0 20px 60px rgba(174, 179, 185, 0.3);
  padding: 40px;
  margin: 20px;
}

.header {
  margin-left: 20px;
  margin-bottom: 20px;
}

.header h1 {
  font-size: 2.5rem;
  color: #333;
  font-weight: 700;
}

.header h1 i {
  color: #669beb;
  margin-right: 10px;
}

.subtitle {
  color: #666;
  font-size: 1.1rem;
}

.main-controls {
  display: flex;
  gap: 2px;
  margin-bottom: 10px;
  align-items: flex-start;
}

.input-section {
  flex: 1;
}

.filters-section {
  flex: 1;
}

.controls {
  border-radius: 10px;
  padding: 20px;
  height: 100%;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.filter-buttons {
  padding-top: 8px;
  display: flex;
  gap: 5px;
}

.filter-buttons button {
  padding: 8px 10px;
  border: 2px solid #e0e0e0;
  background: white;
  border-radius: 30px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s;
  text-align: left;
  display: flex;
  align-items: center;
  color: #333;
  gap: 10px;
}

.filter-buttons button:hover {
  border-color: #6fc50c;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(111, 197, 12, 0.2);
}

.filter-buttons button i {
  font-size: 1.1rem;
  width: 20px;
  text-align: center;
}

.filter-buttons button.active i {
  color: white;
}

/* .filter-buttons button.active  {
  background-color: #87f71f;
} */

.progress-header {
  text-align: center;
}

.progress-percentage {
  font-size: 0.8rem;
  font-weight: 700;
  color: #82887a;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.progress-percentage i {
  font-size: 1.5rem;
}

.progress-bar-container {
  width: 100%;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background-color: #f0f0f0;
  border-radius: 10px;
  overflow: hidden;
  border: 0px solid #c7bfbf;
  margin-top: 5px;
  margin-bottom: 5px;
}

.progress-fill {
  height: 100%;
  background: #4dafdd;
  border-radius: 8px;
  transition: width 0.5s ease;
  position: relative;
  overflow: hidden;
}

.progress-fill::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background-size: 20px 20px;
}

@keyframes move {
  0% {
    background-position: 0 0;
  }

  100% {
    background-position: 20px 0;
  }
}

.progress-footer {
  text-align: center;
  font-size: 0.8rem;
  color: #82887a;
}

.progress-stats i {
  color: #6fc50c;
}

.loading-section {
  text-align: center;
  padding: 40px;
  background: #f8f9fa;
  border-radius: 10px;
  margin-bottom: 20px;
}

.loading-section p {
  margin-top: 15px;
  color: #666;
}

.error-message {
  background-color: #fee;
  color: #c33;
  padding: 15px;
  border-radius: 5px;
  margin: 10px 0;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  border-left: 4px solid #c33;
}

.todo-list-container {
  min-height: 300px;
}

.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #999;
  background: #f8f9fa;
  border-radius: 10px;
  font-size: 1.1rem;
}

.empty-state i {
  font-size: 2rem;
  margin-bottom: 15px;
  color: #6fc50c;
  display: block;
}

.todo-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.footer {
  margin-top: 40px;
  padding-top: 20px;
  border-top: 1px solid #eee;
  text-align: center;
  color: #666;
  font-size: 0.9rem;
}

.footer i {
  margin-right: 5px;
}

.tech {
  margin-top: 5px;
  font-size: 0.8rem;
  color: #999;
}

@media (max-width: 768px) {
  .container {
    padding: 20px;
    margin: 10px;
  }

  .main-controls {
    flex-direction: column;
    gap: 20px;
  }

  .filter-buttons {
    flex-direction: row;
    flex-wrap: wrap;
  }

  .filter-buttons button {
    flex: 1;
    min-width: 150px;
    justify-content: center;
  }

  .progress-percentage {
    font-size: 1.5rem;
  }

  .header h1 {
    font-size: 2rem;
  }
}

@media (max-width: 480px) {
  .filter-buttons {
    flex-direction: column;
  }

  .filter-buttons button {
    width: 100%;
  }

  .progress-percentage {
    font-size: 1.3rem;
  }

  .progress-stats {
    font-size: 0.9rem;
  }
}
</style>
