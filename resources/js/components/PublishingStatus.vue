<template>
  <div>
    <label for="publishingStatus">{{ __('admin.publishing_status') }}</label>
    <b-select id="publishingStatus" name="publishingStatus" v-model="status" :options="options" :disabled="!canUpdate" />
    <div v-if="status === 'Hidden'" class="mt-2">
      <label for="hideReason">{{ __('admin.hide_reason') }}</label>
      <b-select id="hideReason" name="hideReason" v-model="hideReason" :options="hideOptions" :disabled="!canUpdate" />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    canUpdate: {
      type: Boolean,
      required: true
    },
    value: {
      type: String,
      required: false,
      default: null
    },
    hideValue: {
      type: String,
      required: false,
      default: null
    },
    publishingStatuses: {
      type: Object,
      required: true
    },
    hideReasons: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      status: null,
      hideReason: null
    }
  },
  watch: {
    status(newVal) {
      if (newVal !== 'Hidden') {
        this.hideReason = null
      }
    }
  },
  computed: {
    options() {
      return Object.values(this.publishingStatuses)
    },
    hideOptions() {
      return Object.values(this.hideReasons)
    }
  },
  mounted() {
    this.status = this.value
    this.hideReason = this.hideValue
  }
}
</script>