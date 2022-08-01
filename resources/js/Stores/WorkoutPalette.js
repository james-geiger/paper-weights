import { defineStore } from 'pinia'
import { ref } from 'vue'

export const workoutPaletteStore = defineStore('workoutPaletteStore', () => {
    const show = ref(false)
    function toggleWorkoutPalette() {
      show.value = !show.value
    }
  
    return { show, toggleWorkoutPalette }
  })