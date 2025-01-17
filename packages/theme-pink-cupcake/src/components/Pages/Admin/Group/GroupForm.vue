<script setup lang="ts">
import type { GroupEditRequest } from '@userfrosting/sprinkle-admin/interfaces'

/**
 * Form Model
 */
const formData = defineModel<GroupEditRequest>({
    default: {
        slug: '',
        name: '',
        description: '',
        icon: 'users'
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
                <label class="uk-form-label" for="form-stacked-text">Group name</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="pen-to-square" fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        placeholder="Please enter a name for the group"
                        aria-label="Group Name"
                        data-test="name"
                        autofocus
                        tabindex="1"
                        v-model="formData.name" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Slug</label>
                <!-- <span class="pull-right"><a href="#" id="form-register-username-suggest">[{{translate('SUGGEST')}}]</a></span> -->
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="tag" fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        placeholder="Group Slug"
                        aria-label="Group Slug"
                        data-test="slug"
                        tabindex="2"
                        v-model="formData.slug" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Group Icon</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon
                        class="fa-form-icon"
                        :icon="formData.icon"
                        v-if="formData.icon"
                        fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        placeholder="Icon for group members"
                        aria-label="Group Icon"
                        data-test="icon"
                        tabindex="3"
                        v-model="formData.icon" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Description</label>
                <textarea
                    class="uk-textarea"
                    placeholder="Group Description"
                    aria-label="Description"
                    data-test="description"
                    rows="6"
                    tabindex="4"
                    v-model="formData.description" />
            </div>

            <div class="uk-text-right" uk-margin>
                <button class="uk-button uk-button-default uk-modal-close" type="button">
                    Cancel
                </button>
                <button class="uk-button uk-button-primary" type="submit" tabindex="5">Save</button>
            </div>
        </fieldset>
    </form>
</template>
