<template>
  <section v-if="show"
           class="sm-modal-wrap">
    <div class="sm-modal sm-bg-white sm-fadeIn"
         :class="fullWindow">
      <div class="head"
           :class="classes[view]">
        <div class="text">
          <slot name="header"></slot>
        </div>
        <div class="close" @click="onClose()">
          <i class="mdi mdi-close fnt-size-3"></i>
        </div>
      </div>
      <div class="content">
        <slot name="content"></slot>
      </div>
      <div class="foot sm-left">
        <slot name="foot"></slot>
      </div>
    </div>

    <div class="sm-modal-bg" @click="onClose()"></div>
  </section>
</template>

<script>
export default {
  name: "uiModal",

  props: {
    onClose: {
      type   : Function,
      default: () => {
      }
    },
    show   : {
      type   : Boolean,
      default: true
    },
    view   : {
      type   : String,
      default: 'default'
    },
    wpx    : {
      type   : Number,
      default: 400
    },
    full   : {
      type   : Boolean,
      default: false
    }
  },

  data() {
    return {
      classes: {
        default : 'sm-bg-white sm-color-color-1',
      }
    }
  },

  computed: {
    fullWindow() {
      if (this.full) {
        return 'full';
      }
      return 'wpx-' + this.wpx;
    }
  }
}
</script>