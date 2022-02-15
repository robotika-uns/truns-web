<template>
  <editor-content :editor="editor" />
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-2'
import StarterKit from '@tiptap/starter-kit'

export default {
  name: 'EditorComponent',

  components: {
    EditorContent,
  },

  data() {
    return {
      editor: null,
    }
  },

  mounted() {
    this.editor = new Editor({
      editable: false,
      content:
        '<p>I’m running Tiptap with Vue.js. <vue-component username="firmanadiyuda"></vue-component> 🎉<span data-type="mention" data-id="Jennifer Grey"></span> </p> ',
      extensions: [StarterKit],
    })
  },

  beforeDestroy() {
    this.editor.destroy()
  },
}
</script>