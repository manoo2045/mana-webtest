<script setup>
import { ref } from 'vue'

const emit = defineEmits(['addTodo'])
const newTodo = ref('')
const localError = ref('')
const isSubmitting = ref(false)

const clearError = () => {
  localError.value = ''
}

const handleSubmit = async () => {
  if (newTodo.value.trim().length < 3) {
    localError.value = 'Titre trop court'
    return
  }

  isSubmitting.value = true
  localError.value = ''

  try {
    await emit('addTodo', newTodo.value.trim())
    newTodo.value = ''
  } catch (error) {
    localError.value = error.message || 'Erreur lors de l\'ajout'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<template>
  <div class="todo-input">
    <form @submit.prevent="handleSubmit" class="input-form">
      
      <div class="input-group">
        <input
          type="text"
          v-model="newTodo"
          @input="clearError"
          placeholder="Add a new task..."
          :class="{ error: localError }"
        />
        <button type="submit" :disabled="isSubmitting" class="submit-btn">
          <span v-if="isSubmitting">
            <i class="fas fa-spinner fa-spin"></i>
          </span>
          <span v-else>
            <i class="fa-solid fa-circle-plus"></i> Add Task
          </span>
        </button>
      </div>
      <div v-if="localError" class="error-message">
        <i class="fas fa-exclamation-circle"></i> {{ localError }}
      </div>
      <div class="input-hint">
        Min. 3 characters
      </div>
    </form>
  </div>
</template>

<style scoped>
.todo-input {
  height: 100%;
}

.input-form {
  height: 100%;
  display: flex;
  flex-direction: column;
  border-radius: 10px;
  padding: 20px;
}

.input-header {
  margin-bottom: 15px;
}

.input-header h3 {
  color: #333;
  font-size: 1.2rem;
  font-weight: 600;
}

.input-header h3 i {
  color: #6fc50c;
  margin-right: 8px;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 10px;
}

.input-group input {
  flex: 1;
  padding: 12px 16px;
  border: 2px solid #b0b0b0;
  border-radius: 50px;
  font-size: 1rem;
  transition: all 0.3s;
  background-color:#f9f9f9;
}

.input-group input:focus {
  outline: none;
  border-color: #6fc50c;
  box-shadow: 0 0 0 3px rgba(133, 243, 8, 0.2);
}

.input-group input.error {
  border-color: #ff4757;
  background-color: #fff5f5;
}

.submit-btn {
  padding: 12px 25px;
  background: #6fc50c;
  color: white;
  border: none;
  border-radius: 30px;
  width: 60%;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 8px;
}

.submit-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.error-message {
  color: #ff4757;
  font-size: 0.9rem;
  padding: 8px 12px;
  background: #fff5f5;
  border-radius: 5px;
  margin-bottom: 10px;
  border-left: 3px solid #ff4757;
  display: flex;
  align-items: center;
  gap: 8px;
}

.input-hint {
  font-size: 0.7rem;
  color: #666;
  margin-top: auto;
  margin-left: 5px;
  padding-top: 10px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.submit-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem 1.4rem;
  background: #2ecc71;
  color: white;
  border: none;
  border-radius: 999px;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  white-space: nowrap;
  transition: background 0.15s ease, transform 0.1s ease, box-shadow 0.15s ease;
  box-shadow: 0 2px 6px rgba(46, 204, 113, 0.3);
}

.submit-btn:hover:not(:disabled) {
  background: #27ae60;
  box-shadow: 0 4px 10px rgba(46, 204, 113, 0.4);
}

.submit-btn:active:not(:disabled) {
  transform: scale(0.97);
}

.submit-btn:disabled {
  background: #a8dcbd;
  cursor: not-allowed;
  box-shadow: none;
}

.submit-btn i {
  font-size: 0.95rem;
}

</style>