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
                <label class="uk-form-label" for="form-stacked-text">{{ $t('GROUP.NAME') }}</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="pen-to-square" fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        :placeholder="$t('GROUP.NAME_EXPLAIN')"
                        aria-label="Group Name"
                        data-test="name"
                        autofocus
                        tabindex="1"
                        v-model="formData.name" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">{{ $t('SLUG') }}</label>
                <!-- <span class="pull-right"><a href="#" id="form-register-username-suggest">[{{translate('SUGGEST')}}]</a></span> -->
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="tag" fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        :placeholder="$t('SLUG')"
                        aria-label="Group Slug"
                        data-test="slug"
                        tabindex="2"
                        v-model="formData.slug" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">{{ $t('GROUP.ICON') }}</label>
                <span class="uk-text-meta">{{ $t('GROUP.ICON_EXPLAIN') }}</span>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon
                        class="fa-form-icon"
                        :icon="formData.icon"
                        v-if="formData.icon"
                        fixed-width />
                    <input
                        class="uk-input"
                        type="text"
                        :placeholder="$t('GROUP.ICON')"
                        aria-label="Group Icon"
                        data-test="icon"
                        tabindex="3"
                        v-model="formData.icon" />
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">{{ $t('DESCRIPTION') }}</label>
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
                    {{ $t('CANCEL') }}
                </button>
                <button class="uk-button uk-button-primary" type="submit" tabindex="5">
                    {{ $t('SAVE') }}
                </button>
            </div>
        </fieldset>
    </form>
</template>
