<template>
    <div v-if="editor">
        <div class="uk-button-group rounded-group">
            <button data-htmleditor-button="Undo" title="Undo" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().undo().run()">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M13.5 7a6.5 6.5 0 0 1 6.5 6.5a6.5 6.5 0 0 1-6.5 6.5H10v-2h3.5c2.5 0 4.5-2 4.5-4.5S16 9 13.5 9H7.83l3.08 3.09L9.5 13.5L4 8l5.5-5.5l1.42 1.41L7.83 7h5.67M6 18h2v2H6v-2Z"/></svg>
            </button>
            <button data-htmleditor-button="Redo" title="Redo" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().redo().run()">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 7A6.5 6.5 0 0 0 4 13.5a6.5 6.5 0 0 0 6.5 6.5H14v-2h-3.5C8 18 6 16 6 13.5S8 9 10.5 9h5.67l-3.08 3.09l1.41 1.41L20 8l-5.5-5.5l-1.42 1.41L16.17 7H10.5M18 18h-2v2h2v-2Z"/></svg>
            </button>
        </div>
        <div class="uk-button-group rounded-group">
            <button data-htmleditor-button="bold" title="Bold" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().toggleBold().run()" :class="{ 'uk-active': editor.isActive('bold') }">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M13.5 15.5H10v-3h3.5A1.5 1.5 0 0 1 15 14a1.5 1.5 0 0 1-1.5 1.5m-3.5-9h3A1.5 1.5 0 0 1 14.5 8A1.5 1.5 0 0 1 13 9.5h-3m5.6 1.29c.97-.68 1.65-1.79 1.65-2.79c0-2.26-1.75-4-4-4H7v14h7.04c2.1 0 3.71-1.7 3.71-3.79c0-1.52-.86-2.82-2.15-3.42Z"/></svg>
            </button>
            <button data-htmleditor-button="Italic" title="Italic" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'uk-active': editor.isActive('italic') }">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4h-8Z"/></svg>
            </button>
            <button data-htmleditor-button="Strikethrough" title="Strikethrough" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'uk-active': editor.isActive('strike') }">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M23 12v2h-4.39c1 2.14.95 8-6.23 8c-8.33.05-8.01-6.5-8.01-6.5l3.97.05c.03 3.37 3.16 3.37 3.78 3.33c.64-.05 3.03-.04 3.22-2.38c.08-1.09-1.02-1.92-2.22-2.5H1v-2h22m-3.59-4.11l-3.98-.03s.17-2.77-3.28-2.78C8.7 5.06 9 7.28 9 7.56c.04.28.34 1.66 3 2.32H5.71S2.22 3.15 10.74 2c8.71-1.2 8.69 5.91 8.67 5.89Z"/></svg>
            </button>
        </div>
        <button data-htmleditor-button="Neuređena lista" title="Neuređena lista" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-border-rounded uk-button-default uk-icon" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'uk-active': editor.isActive('bulletList') }">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M7 5h14v2H7V5m0 8v-2h14v2H7M4 4.5A1.5 1.5 0 0 1 5.5 6A1.5 1.5 0 0 1 4 7.5A1.5 1.5 0 0 1 2.5 6A1.5 1.5 0 0 1 4 4.5m0 6A1.5 1.5 0 0 1 5.5 12A1.5 1.5 0 0 1 4 13.5A1.5 1.5 0 0 1 2.5 12A1.5 1.5 0 0 1 4 10.5M7 19v-2h14v2H7m-3-2.5A1.5 1.5 0 0 1 5.5 18A1.5 1.5 0 0 1 4 19.5A1.5 1.5 0 0 1 2.5 18A1.5 1.5 0 0 1 4 16.5Z"/></svg>
        </button>
        <button data-htmleditor-button="Uređena lista" title="Uređena lista" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-border-rounded uk-button-default uk-icon" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'uk-active': editor.isActive('orderedList') }">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M8 4h13v2H8V4zM5 3v3h1v1H3V6h1V4H3V3h2zM3 14v-2.5h2V11H3v-1h3v2.5H4v.5h2v1H3zm2 5.5H3v-1h2V18H3v-1h3v4H3v-1h2v-.5zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/></svg>
        </button>
        <div class="uk-button-group rounded-group">
            <button data-htmleditor-button="Poravnanje teksta levo" title="Poravnanje teksta levo" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().setTextAlign('left').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'left' }) }">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M14 15H4c-.55 0-1 .45-1 1s.45 1 1 1h10c.55 0 1-.45 1-1s-.45-1-1-1zm0-8H4c-.55 0-1 .45-1 1s.45 1 1 1h10c.55 0 1-.45 1-1s-.45-1-1-1zM4 13h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm0 8h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zM3 4c0 .55.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1z"/></svg>
            </button>
            <button data-htmleditor-button="Poravnanje teksta na sredinu" title="Poravnanje teksta na sredinu" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().setTextAlign('center').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'center' }) }">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M7 16c0 .55.45 1 1 1h8c.55 0 1-.45 1-1s-.45-1-1-1H8c-.55 0-1 .45-1 1zm-3 5h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm0-8h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm3-5c0 .55.45 1 1 1h8c.55 0 1-.45 1-1s-.45-1-1-1H8c-.55 0-1 .45-1 1zM3 4c0 .55.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1z"/></svg>
            </button>
            <button data-htmleditor-button="Poravnanje teksta desno" title="Poravnanje teksta desno" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().setTextAlign('right').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'right' }) }">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M4 21h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm6-4h10c.55 0 1-.45 1-1s-.45-1-1-1H10c-.55 0-1 .45-1 1s.45 1 1 1zm-6-4h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm6-4h10c.55 0 1-.45 1-1s-.45-1-1-1H10c-.55 0-1 .45-1 1s.45 1 1 1zM3 4c0 .55.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1z"/></svg>
            </button>
            <button data-htmleditor-button="Poravnanje teksta justify" title="Poravnanje teksta justify" data-uk-tooltip="" class="uk-button uk-button-small icon-button uk-button-default uk-icon" @click="editor.chain().focus().setTextAlign('justify').run()" :class="{ 'uk-active': editor.isActive({ textAlign: 'justify' }) }">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M4 21h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm0-4h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm0-4h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zm0-4h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1s.45 1 1 1zM3 4c0 .55.45 1 1 1h16c.55 0 1-.45 1-1s-.45-1-1-1H4c-.55 0-1 .45-1 1z"/></svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "TipTapMenu.vue",
    props: ['editor']
}
</script>

<style scoped>

</style>
