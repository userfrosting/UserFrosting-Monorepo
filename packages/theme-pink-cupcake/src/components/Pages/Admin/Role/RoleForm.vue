<script setup lang="ts">
import type { RoleCreateRequest, RoleEditRequest } from '@userfrosting/sprinkle-admin/interfaces'

/**
 * Form Model
 */
const formData = defineModel<RoleCreateRequest | RoleEditRequest>({
    default: {
        name: '',
        slug: '',
        description: ''
    }
})

/**
 * Emits
 */
const emits = defineEmits(['submit'])
</script>

<template>
    <form v-on:submit.prevent="emits('submit')">
        <fieldset class="uk-fieldset uk-form-stacked">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Name</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="pen-to-square" fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        placeholder="Please enter a name for the role"
                        aria-label="Role Name"
                        data-test="name"
                        autofocus
                        tabindex="1"
                        v-model="formData.name" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Slug</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="tag" fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        placeholder="Role Slug"
                        aria-label="Role Slug"
                        data-test="slug"
                        tabindex="2"
                        v-model="formData.slug" />
                </div>
                <!-- TODO : Disable + unlock button; Auto generate slug -->
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Description</label>
                <textarea
                    class="uk-textarea"
                    placeholder="Role Description"
                    aria-label="Description"
                    data-test="description"
                    rows="6"
                    tabindex="3"
                    v-model="formData.description" />
            </div>

            <div class="uk-text-right" uk-margin>
                <button class="uk-button uk-button-default uk-modal-close" type="button">
                    Cancel
                </button>
                <button class="uk-button uk-button-primary" type="submit" tabindex="4">Save</button>
            </div>
        </fieldset>
    </form>
</template>
