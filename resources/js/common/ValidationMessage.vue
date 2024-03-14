<template>
    <div v-if="type == 'object'">
        <div v-if="modelValue.$error && show">
            <!-- show only first error -->
            <span v-for="(error, index) of modelValue.$errors" :key="index">
                <small class="text-error">{{ prepareMessage(error.$message) }}</small>
            </span>
        </div>
        <div v-else-if="modelValue.$serverError && show">
            <span v-for="(error, index) of modelValue.$serverError" :key="index">
                <small class="text-error">{{ prepareMessage(error) }}</small>
            </span>
        </div>
    </div>
    <div v-else-if="type == 'string'">
        <div v-if="modelValue && show">
            <small class="text-error">{{ prepareMessage(modelValue) }}</small>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Object || String,
        required: true,
    },
    show: {
        type: Boolean,
        required: false,
        default: true,
    },
    label: {
        type: String,
        required: false,
        default: null,
    },
});

const prepareMessage = (message) => {
    let label = props.label;
    if (label) {
        return message.replace('Value', label);
    }
    return message;
};

const type = computed(() => {
    // check if modelValue is an object or string
    if (typeof props.modelValue === 'object') {
        return 'object';
    }
    return 'string';
});

</script>
