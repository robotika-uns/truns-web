<template>
  <editor-content class="font-normal" :editor="editor" />
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-2'
import StarterKit from '@tiptap/starter-kit'
import Mention from '~/plugins/tiptap/mention/CustomMention'

export default {
  name: 'TipTapRenderComponent',
  components: {
    EditorContent,
  },
  props: {
    data: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      editor: null,
    }
  },

  mounted() {
    this.editor = new Editor({
      editable: false,
      extensions: [StarterKit, Mention],
      content: this.data,
    })
  },

  beforeDestroy() {
    this.editor.destroy()
  },
}
</script>