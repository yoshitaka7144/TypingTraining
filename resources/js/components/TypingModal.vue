<template>
  <modal class="modal" name="typing-modal" :resizable="true">
    {{ questionCount }}
  </modal>
</template>
<script>
export default {
  props: {
    modalOption: {},
    questions: [],
    questionCount: "",
  },
  methods: {
    hide() {
      this.$modal.hide("modal");
    },
  },
};
</script>