import { VueRenderer } from '@tiptap/vue-2'
import tippy from 'tippy.js'
import axios from 'axios'
import MentionList from '~/components/mention/List.vue'

export default {
  items: async ({ query }) => {
    if (!query) return 'initiate'

    const apiURL =
      process.env.NODE_ENV !== 'production'
        ? 'http://localhost:8000'
        : 'https://robotika.uns.ac.id/api'
    const { data } = await axios.get(`${apiURL}/user/?q=${query}`)

    return data.data
  },

  render: () => {
    let component
    let popup

    return {
      onStart: (props) => {
        component = new VueRenderer(MentionList, {
          parent: this,
          propsData: props,
        })

        popup = tippy('body', {
          getReferenceClientRect: props.clientRect,
          appendTo: () => document.body,
          content: component.element,
          showOnCreate: true,
          interactive: true,
          trigger: 'manual',
          placement: 'bottom-start',
        })
      },

      onUpdate(props) {
        component.updateProps(props)

        popup[0].setProps({
          getReferenceClientRect: props.clientRect,
        })
      },

      onKeyDown(props) {
        if (props.event.key === 'Escape') {
          popup[0].hide()

          return true
        }

        return component.ref?.onKeyDown(props)
      },

      onExit() {
        popup[0].destroy()
        component.destroy()
      },
    }
  },
}
