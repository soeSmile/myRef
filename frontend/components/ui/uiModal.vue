<template>
  <section v-if="show"
           class="sm-modal-wrap">
    <div class="sm-modal sm-bg-white animated fadeIn"
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
      default: 'teal'
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
        white : 'sm-bg-white sm-color-dark',
        blue  : 'sm-bg-blue-l sm-color-blue',
        red   : 'sm-bg-red-l sm-color-red',
        orange: 'sm-bg-orange-l sm-color-orange',
        teal  : 'sm-bg-teal-l sm-color-teal',
        grey  : 'sm-bg-grey-l sm-color-grey',
        dark  : 'sm-bg-dark-l sm-color-dark'
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