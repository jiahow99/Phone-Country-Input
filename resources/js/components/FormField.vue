<template>
  <DefaultField
    :field="field"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="w-full flex flex-row justify-between">
        <!-- Country Code -->
        <div class="flex relative w-full" style="width: 15%">
          <select
            class="w-full block form-control form-select form-select-bordered"
            v-model="callingCode"
          >
            <option v-for="option in field.options" :value="option.value" :key="option.value">
              {{ option.label }}
            </option>
          </select>
          <svg class="flex-shrink-0 pointer-events-none form-select-arrow" xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"><path class="fill-current" d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"></path></svg>
        </div>
        <!-- Phone -->
        <input
          :id="field.attribute"
          type="number"
          class="form-control form-input form-input-bordered"
          style="width: 85%"
          :class="errorClasses"
          :placeholder="field.name"
          required
          v-model="phone"
        />
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'
import parsePhoneNumber from 'libphonenumber-js'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      callingCode: '',
      phone: '',
    }
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      if (this.field.value) {
        const {countryCallingCode, nationalNumber} = parsePhoneNumber('+' + this.field.value.toString())
        this.callingCode = countryCallingCode
        this.phone = nationalNumber
      } else {
        this.callingCode = '60'
      }
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      const result = this.callingCode.toString() + this.phone.toString()
      formData.append(this.field.attribute, result || '')
    },
  },
}
</script>
