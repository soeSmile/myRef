<template>
  <section>

    <div @click="addRef"
         title="Добавить закладку"
         class="sm-menu-item link sm-flex middle sm-link"
         :class="show ? 'left' : 'center'">
      <div class="icon">
        <i class="mdi mdi-link"></i>
      </div>
      <div class="text"
           :class="{ 'active' : show }">
        Добавить ссылку
      </div>
    </div>
    <div @click="addNote"
         title="Добавить заметку"
         class="sm-menu-item link sm-flex middle sm-link"
         :class="show ? 'left' : 'center'">
      <div class="icon">
        <i class="mdi mdi-note"></i>
      </div>
      <div class="text"
           :class="{ 'active' : show }">
        Добавить запись
      </div>
    </div>

  </section>
</template>

<script>

import addRef from "../../ref/addRef";
import addNote from "../../note/addNote";

export default {
  name: "siteMenuUser",

  components: {
    addRef,
    addNote
  },

  props: {
    show: false
  },

  data() {
    return {};
  },

  methods: {
    /**
     * add ref
     */
    addRef() {
      this.$buefy.modal.open({
        parent      : this,
        component   : addRef,
        hasModalCard: true,
        canCancel   : false,
        fullScreen  : true
      })
    },

    /**
     * add note
     */
    addNote() {
      this.$buefy.modal.open({
        parent      : this,
        component   : addNote,
        hasModalCard: true,
        canCancel   : false,
        fullScreen  : true
      })
    }
  },
};
</script>