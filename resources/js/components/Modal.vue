<template>
  <modal class="modal" name="modal" :resizable="true">
    <p>確認</p>
    <p>{{ modalOption.action }}：実行してよろしいですか？</p>
    <button
      class="btn btn-blue"
      @click="modalOption.afterConfirmationFunction(modalOption.targetQuestionId); hide();">
      OK
    </button>
    <button class="btn btn-gray" @click="hide">戻る</button>
  </modal>
</template>
<script>
export default {
  props: {
    modalOption: {
      action: "",
      targetQuestionId: "",
      afterConfirmationFunction: "",
    },
  },
  methods: {
    hide() {
      this.$modal.hide("modal");
    },
  },
};
</script>