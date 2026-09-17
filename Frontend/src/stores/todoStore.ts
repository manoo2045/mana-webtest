// src/stores/todoStore.ts
import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export interface Todo {
  id: number
  title: string
  is_completed: boolean
}


export type TodoFilter = 'all' | 'active' | 'completed'

export const useTodoStore = defineStore('todo', () => {

  const todos = ref<Todo[]>([])
  const loading = ref<boolean>(false)
  const error = ref<string | null>(null)
  const filter = ref<TodoFilter>('all')

  const fetchTodos = async (): Promise<void> => {
    loading.value = true
    error.value = null
    try {
      const response = await fetch('http://localhost:8000/api/tasks')
      if (!response.ok) throw new Error('Erreur de chargement')
      todos.value = await response.json() as Todo[]
    } catch (err) {
      error.value = (err as Error).message
    } finally {
      loading.value = false
    }
  }

  const addTodo = async (title: string): Promise<Todo> => {
    loading.value = true
    error.value = null
    try {
      const response = await fetch('http://localhost:8000/api/tasks', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title })
      })

      if (!response.ok) {
        const data = await response.json()
        throw new Error(data.message || 'Erreur d\'ajout')
      }

      const newTodo = await response.json() as Todo
      todos.value.push(newTodo)
      return newTodo
    } catch (err) {
      error.value = (err as Error).message
      throw err
    } finally {
      loading.value = false
    }
  }

  const toggleTodo = async (id: number): Promise<void> => {
    try {
      const response = await fetch(`http://localhost:8000/api/tasks/${id}`, {
        method: 'PATCH'
      })

      if (!response.ok) throw new Error('Erreur de mise à jour')

      const updatedTodo = await response.json() as Todo

      const index = todos.value.findIndex(todo => todo.id === id)
      if (index !== -1) {
        todos.value[index] = updatedTodo
      }
      console.log('Réponse API:', updatedTodo)
    } catch (err) {
      error.value = (err as Error).message
      console.error(err)
    }
  }

  const deleteTodo = async (id: number): Promise<void> => {
    try {
      const response = await fetch(`http://localhost:8000/api/tasks/${id}`, {
        method: 'DELETE'
      })
      if (!response.ok) throw new Error('Erreur de suppression')

      todos.value = todos.value.filter(todo => todo.id !== id)
    } catch (err) {
      error.value = (err as Error).message
    }
  }

  const filteredTodos = computed<Todo[]>(() => {
    switch (filter.value) {
      case 'active':
        return todos.value.filter(todo => !todo.is_completed)
      case 'completed':
        return todos.value.filter(todo => todo.is_completed)
      default:
        return todos.value
    }
  })

  const remainingCount = computed<number>(() => {
    return todos.value.filter(todo => !todo.is_completed).length
  })

  return {
    todos,
    loading,
    error,
    filter,
    filteredTodos,
    remainingCount,
    fetchTodos,
    addTodo,
    toggleTodo,
    deleteTodo
  }
})