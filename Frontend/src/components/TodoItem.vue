<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  todo: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['toggle', 'delete'])

const handleToggle = () => {
  emit('toggle', props.todo.id)
}

const handleDelete = () => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
    emit('delete', props.todo.id)
  }
}

</script>

<template>
  <div class="todo-item" :class="{ completed: todo.is_completed }">
    <div class="todo-content">
      <div class="checkbox-container" @click="handleToggle">
        <div class="checkbox" :class="{ checked: todo.is_completed }">
          <i v-if="todo.is_completed" class="fas fa-check"></i>
        </div>
      </div>
      
      <div class="todo-text">
        <div class="todo-title">{{ todo.title }}</div>
        <div class="todo-meta">
          <span class="comment">
            <p> {{ todo.created_at }}</p>
          </span>
        </div>
      </div>

      <div class="todo-actions">
        <button @click="handleDelete" class="delete-btn" title="Supprimer">
          <i class="fas fa-trash"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>

.todo-item {
  background: white;
  border-radius: 20px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: all 0.3s;
}

.todo-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

.todo-item.completed {
  opacity: 0.7;
  border-left-color: #85f308;
}

.todo-content {
  display: flex;
  align-items: center;
  gap: 20px;
}

.checkbox-container {
  cursor: pointer;
}

.checkbox {
  width: 24px;
  height: 24px;
  border: 2px solid #6fc50c;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s;
}

.checkbox.checked {
  background: #6fc50c;
  border-color: #6fc50c;
  color: white;
}

.todo-text {
  flex: 1;
}

.todo-title {
  font-size: 1.1rem;
  color: #333;
  margin-bottom: 5px;
  word-break: break-word;
}

.todo-item.completed .todo-title {
  color: #999;
}

.todo-meta {
  display: flex;
  gap: 15px;
  font-size: 0.9rem;
}

.comment {
  color: #888;
  display: flex;
  align-items: center;
  gap: 5px;
}

.todo-actions {
  display: flex;
  gap: 10px;
}

.toggle-btn, .delete-btn {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.delete-btn {
  background: #ffebee;
  color: #ff0000;
  border: 2px solid #ff0000;
  padding: 10px 9px;
  border-radius: 50%;
}

.delete-btn:hover {
  background: #ffcdd2;
  transform: translateY(-1px);
}

@media (max-width: 768px) {
  .todo-content {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .todo-actions {
    align-self: flex-end;
  }
}
</style>