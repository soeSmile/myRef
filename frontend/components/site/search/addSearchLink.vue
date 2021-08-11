<template>
  <ui-modal :onClose="() => $emit('close')"
            :wpx="600">
    <template slot="header">
      Добавить в поиск
    </template>
    <template slot="content">
      <div class="sm-flex col">
        <div class="sm-flex col sm-mb-2">
          <label class="sm-label">Имя</label>
          <el-input v-model="searchUrl.name"
                    autocomplete="off"
                    placeholder="Имя"/>
        </div>
      </div>
    </template>
    <template slot="foot">
      <el-button type="primary"
                 @click="$emit('store')"
                 :disabled="loading">
        Сохранить
      </el-button>
      <el-button @click="$emit('close')"
                 :disabled="loading">
        Отмена
      </el-button>
    </template>
  </ui-modal>
</template>

<script>
import uiModal from "../../ui/uiModal";

export default {
  name: "addSearchLink",

  components: {
    uiModal
  },

  created() {
  },

  mounted() {
  },

  props: {
    searchUrl: {}
  },

  data() {
    return {
      loading: false,
    }
  },
}
</script>