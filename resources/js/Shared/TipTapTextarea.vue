<template>
    <div>
        <div v-if="editor">
            <div class="uk-button-group rounded-group">
                <button data-htmleditor-button="Undo" title="Undo" data-uk-tooltip="Undo" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().undo().run()">
                    <img src="/icons/undo.svg" alt="Undo" uk-svg>
                </button>
                <button data-htmleditor-button="Redo" title="Redo" data-uk-tooltip="Redo" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().redo().run()">
                    <img src="/icons/redo.svg" alt="Redo" uk-svg>
                </button>
            </div>
            <div class="uk-button-group rounded-group uk-margin-small-left">
                <button data-htmleditor-button="bold" title="Bold" data-uk-tooltip="Bold" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().toggleBold().run()" :class="{ 'uk-active': editor.isActive('bold') }">
                    <img src="/icons/bold.svg" alt="Bold" uk-svg>
                </button>
                <button data-htmleditor-button="Italic" title="Italic" data-uk-tooltip="Italic" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().toggleItalic().run()" :class="{ 'uk-active': editor.isActive('italic') }">
                    <img src="/icons/italic.svg" alt="Italic" uk-svg>
                </button>
                <button data-htmleditor-button="Strikethrough" title="Strikethrough" data-uk-tooltip="Strikethrough" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().toggleStrike().run()" :class="{ 'uk-active': editor.isActive('strike') }">
                    <img src="/icons/strikethrough.svg" alt="Strikethrough" uk-svg>
                </button>
            </div>
            <button data-htmleditor-button="Neuređena lista" title="Neuređena lista" data-uk-tooltip="Neuređena lista" class="uk-button uk-button-small icon-button uk-border-rounded uk-button-default uk-icon uk-margin-small-left" @click.prevent="editor.chain().focus().toggleBulletList().run()" :class="{ 'uk-active': editor.isActive('bulletList') }">
                    <img src="/icons/ul.svg" alt="U Lista" uk-svg>
            </button>
            <button data-htmleditor-button="Uređena lista" title="Uređena lista" data-uk-tooltip="Uređena lista" class="uk-button uk-button-small icon-button uk-border-rounded uk-button-default uk-icon uk-margin-small-left" @click.prevent="editor.chain().focus().toggleOrderedList().run()" :class="{ 'uk-active': editor.isActive('orderedList') }">
                    <img src="/icons/ol.svg" alt="N Lista" uk-svg>
            </button>
            <div class="uk-button-group rounded-group uk-margin-small-left">
                <button data-htmleditor-button="Poravnanje teksta levo" title="Poravnanje teksta levo" data-uk-tooltip="Poravnanje teksta levo" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().setTextAlign('left').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'left' }) }">
                    <img src="/icons/align_left.svg" alt="levo" uk-svg>
                </button>
                <button data-htmleditor-button="Poravnanje teksta na sredinu" title="Poravnanje teksta na sredinu" data-uk-tooltip="Poravnanje teksta na sredinu" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().setTextAlign('center').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'center' }) }">
                    <img src="/icons/align_center.svg" alt="sredina" uk-svg>
                </button>
                <button data-htmleditor-button="Poravnanje teksta desno" title="Poravnanje teksta desno" data-uk-tooltip="Poravnanje teksta desno" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().setTextAlign('right').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'right' }) }">
                    <img src="/icons/align_right.svg" alt="desno" uk-svg>
                </button>
                <button data-htmleditor-button="Poravnanje teksta justify" title="Poravnanje teksta justify" data-uk-tooltip="Poravnanje teksta justify" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().setTextAlign('justify').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'justify' }) }">
                    <img src="/icons/align_justify.svg" alt="justify" uk-svg>
                </button>
            </div>
        </div>

        <bubble-menu :editor="editor" :tippy-options="{ duration: 100 }" v-if="editor">

            <button data-htmleditor-button="bold" title="Bold" data-uk-tooltip="Bold" class="uk-button uk-button-small uk-border-rounded icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().toggleBold().run()" :class="{ 'uk-active': editor.isActive('bold') }">
                    <img src="/icons/bold.svg" alt="Bold" uk-svg>
            </button>
            <button data-htmleditor-button="Italic" title="Italic" data-uk-tooltip="Italic" class="uk-button uk-button-small uk-border-rounded icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().toggleItalic().run()" :class="{ 'uk-active': editor.isActive('italic') }">
                    <img src="/icons/italic.svg" alt="Italic" uk-svg>
            </button>
            <button data-htmleditor-button="Strikethrough" title="Strikethrough" data-uk-tooltip="Strikethrough" class="uk-button uk-button-small uk-border-rounded icon-button uk-button-default uk-icon" @click.prevent="editor.chain().focus().toggleStrike().run()" :class="{ 'uk-active': editor.isActive('strike') }">
                    <img src="/icons/strikethrough.svg" alt="Strikethrough" uk-svg>
            </button>

          </bubble-menu>

        <editor-content :editor="editor" />

        <div class="uk-grid" v-if="editor">
            <div class="uk-width-expand">
                Br. Reči: {{ editor.storage.characterCount.words() }}
            </div>
            <div class="uk-width-auto">
                Karaktera: {{ editor.storage.characterCount.characters() }}/{{ limit }}
            </div>
        </div>
    </div>
</template>

<script>
import { BubbleMenu, Editor, EditorContent } from '@tiptap/vue-3'

import CharacterCount from '@tiptap/extension-character-count';
import Placeholder from '@tiptap/extension-placeholder';
import StarterKit from '@tiptap/starter-kit';
import Document from '@tiptap/extension-document';
import TextAlign from '@tiptap/extension-text-align';

export default {
    name: "TipTapTextarea",
    props: {
        'content': {},
        'error': {},
        'btn_variant': {
            default: 1
        },
        'autofocus': {
            default: true
        },
        'limit': {
            default: 2000,
        },
        'placeholder': {
            default: 'Opis objekta...'
        }
    },
    components: {
        EditorContent,
        BubbleMenu,
    },
    data() {
        return {
            editor: null,
        }
    },
    watch: {
        'content': {
            handler:function(value) {
                // HTML
                const isSame = this.editor.getHTML() === value

                // JSON
                // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

                if (isSame) {
                    return
                }

                this.editor.commands.setContent(value, false)
            }
        },
        error: {
            handler: function (value) {
                if(this.editor === null) {
                    return;
                }

                let formClass = value ? 'uk-textarea uk-form-danger' : 'uk-textarea';

                this.editor.setOptions({
                    editorProps: {
                        attributes: {
                            class: formClass,
                        },
                    },
                })
            }
        }
    },
    mounted() {
        this.editor = new Editor({
            editorProps: {
                attributes: {
                    class: 'uk-textarea modified-input',
                },
            },
            content: this.content,
            extensions: [
                StarterKit,
                Placeholder.configure({
                    // Use a placeholder:
                    placeholder: this.placeholder,
                }),
                Document,
                TextAlign.configure({
                    types: ['heading', 'paragraph'],
                }),
                CharacterCount.configure({
                    limit: this.limit,
                }),
            ],
            autofocus: this.autofocus,
            onUpdate: () => {
                // HTML
                this.$emit('update:content', this.editor.getHTML());

                // JSON
                // this.$emit('input', this.editor.getJSON())
            },
        })
    },

    beforeDestroy() {
        this.editor.destroy()
    },
}
</script>

<style lang="scss">
/* Basic editor styles */
.ProseMirror {
    > * + * {
        margin-top: 0.75em;
    }
}
.ProseMirror {
    margin-top: 10px;
    min-height: 200px;
    border-radius: 0 0 4px 4px;
}

/* Placeholder (at the top) */
.ProseMirror p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    color: #adb5bd;
    pointer-events: none;
    height: 0;
}
.character-count {
    margin-top: 1rem;
    color: #868e96;
}
/* Placeholder (on every new line) */
/*.ProseMirror p.is-empty::before {
  content: attr(data-placeholder);
  float: left;
  color: #adb5bd;
  pointer-events: none;
  height: 0;
}*/
.tippy-content .uk-button-default:hover {
    background: linear-gradient(to bottom, #ffffff, #eeeeee);
}
.tippy-content .uk-button.uk-button-small.icon-button {
    padding: 0 7px;
}
.ProseMirror li > p {
    margin: 0;
}
</style>
