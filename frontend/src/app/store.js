// src/app/store.js
import { configureStore } from '@reduxjs/toolkit';
// import yourSliceReducer from '../features/yourFeature/yourSlice'; // Ejemplo

export const store = configureStore({
  reducer: {
    // yourFeature: yourSliceReducer, // Añade tus reducers aquí
  },
});