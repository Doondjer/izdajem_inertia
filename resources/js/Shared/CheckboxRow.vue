<template>
    <div class="uk-card-header">
        <label :for="`${label.trim().toLowerCase().replace(/\s+/g, '_')}_row_checkboxes`" class="uk-text-small uk-text-bold" v-text="`${label}:`"></label>
        <ul class="uk-nav" :id="`${label.trim().toLowerCase().replace(/\s+/g, '_')}_row_checkboxes`">
            <li v-for="i in items">
                <input type="checkbox"
                       class="uk-checkbox uk-margin-small-right"
                       :value="i.key"
                       :name="`${item}[]`"
                       v-model="form[item]"
                       :id="`${i.key}_row_checkbox`"
                >
                <label :for="`${i.key}_row_checkbox`" v-text="i.key"></label> <span v-text="`(${i.doc_count})`" v-if="i.doc_count > 0"></span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['form', 'label', 'items', 'item']
}
</script>
