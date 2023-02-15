<template>
    <div>
        
    </div>
  </template>
  
  <script>
  import pdfMake from 'pdfmake'
  export default {
    name: 'pdfmake',
    mounted() {
      this.export()
    },
    methods: {
      export () {
        const docDefinition = {
        content: [
            'English',
            'ไทย'
          ]
        }
        pdfMake.fonts = {
          // download default Roboto font from cdnjs.com
          Roboto: {
            normal: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Regular.ttf',
            bold: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Medium.ttf',
            italics: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-Italic.ttf',
            bolditalics: 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/fonts/Roboto/Roboto-MediumItalic.ttf'
          }
        }
        pdfMake.createPdf(docDefinition).open({}, window)
      }
    }
  }
  </script>