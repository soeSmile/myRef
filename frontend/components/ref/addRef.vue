<template>
  <el-dialog title="Shipping address" :visible.sync="showAddRef.show">
    <el-form :model="myRef">
      <el-form-item label="Promotion name">
        <el-input v-model="myRef.url" autocomplete="off"></el-input>
      </el-form-item>
      <el-form-item label="Zones">
        <el-select v-model="myRef.category" placeholder="Please select a zone">
          <el-option label="Zone No.1" value="shanghai"></el-option>
          <el-option label="Zone No.2" value="beijing"></el-option>
        </el-select>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible = false">Cancel</el-button>
    <el-button type="primary" @click="dialogFormVisible = false">Confirm</el-button>
  </span>
  </el-dialog>
</template>

<script>
export default {
  name: "addRef",

  props: {
    showAddRef: {}
  },

  data() {
    return {
      showDate : false,
      myRef    : {
        url     : null,
        category: null,
        tags    : [],
        date    : null,
        comment : null,
        cache   : false
      },
      searchTag: null,
      tags     : [],
      errors   : {}
    }

  },

  computed: {
    categories() {
      return this.$store.getters['category/categories'];
    }
  },

  watch: {
    searchTag: function (newVal) {
      if (newVal && newVal.length > 2) {
        this.getTags()
      }
    }
  },

  methods: {
    store() {
      this.$axios.post('api/links', this.prepareData(this.myRef))
          .then(response => {
            this.$toast.success({
              title  : 'Success',
              message: 'Saved',
            })
            this.dialog.show = false
            this.$store.dispatch('links/setUrl', {params: this.$route.query})
          })
          .catch(e => {
            this.errors = e.response.data.errors;

            this.$toast.error({
              title  : 'Error',
              useHtml: true,
              message: this.$messageToStr(this.errors),
            })
          });
    },

    /**
     * @return {{}}
     */
    prepareData(ref) {
      return {
        url       : ref.url,
        categoryId: ref.category,
        tags      : ref.tags.length === 0 ? null : ref.tags,
        date      : ref.date,
        comment   : ref.comment,
        cache     : ref.cache
      }
    },

    /**
     * get tags
     */
    getTags() {
      this.$axios.get('/api/tags', {params: {tag: this.searchTag}})
          .then(response => {
            this.tags = response.data.data;
          })
          .catch(error => {
            console.log(error)
          })
    },
  }
}
</script>