<template>
  <div>
    <b-select name="publishingStatus" v-model="status" :options="options" :disabled="!canUpdate" />
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
    publishingStatuses: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      status: null
    }
  },
  computed: {
    options() {
      return Object.values(this.publishingStatuses)
    }
  },
  mounted() {
    this.status = this.value
  }
}
</script>