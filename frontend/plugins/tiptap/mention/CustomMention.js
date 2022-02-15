import { mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-2'
import { Mention } from '@tiptap/extension-mention'
import MentionComponent from '~/components/Mention.vue'
import suggestion from '~/plugins/tiptap/mention/suggestion'

export default Mention.extend({
  addAttributes() {
    return {
      ...this.parent?.(),
      username: {
        default: null,
        parseHTML: (element) => element.getAttribute('username'),
      },
    }
  },
  renderHTML({ node, HTMLAttributes }) {
    return [
      'mention',
      mergeAttributes(
        { 'data-type': this.name },
        this.options.HTMLAttributes,
        HTMLAttributes
      ),
    ]
  },
  parseHTML() {
    return [
      {
        tag: `mention[data-type="${this.name}"] `,
      },
    ]
  },
  addNodeView() {
    return VueNodeViewRenderer(MentionComponent)
  },
}).configure({
  HTMLAttributes: {},
  suggestion,
})
