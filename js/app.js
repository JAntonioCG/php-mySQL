document.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search) 
  console.log('params => ', params)
  if (params) {
    const mensaje = params.get('mensaje')
    console.log('params => ', params, mensaje)
  }
})