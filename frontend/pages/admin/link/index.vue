<template>
  <section>
    <nav class="sm-nav sm-bg-white sm-color-grey sm-p-2">
      <div class="sm-nav-start">
        <div class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary"
             @click="getAll(true)">
          <i class="mdi mdi-reload sm-mr-1"></i>
          <span>Обновить</span>
        </div>
        <n-link to="/admin/link/new"
                class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-plus sm-mr-1"></i>
          <span>Добавить</span>
        </n-link>
        <div @click="askReBuild"
             class="sm-nav-item sm-px-4 sm-py-2 sm-m-1 sm-radius-3 sm-link sm-hover-white sm-hover-bg-primary">
          <i class="mdi mdi-image-broken-variant sm-mr-1"></i>
          <span>Обновить картинки</span>
        </div>
      </div>
      <div class="sm-nav-end">
      </div>
    </nav>

    <div class="sm-p-4">
      <b-table
          :data="links"
          :loading="loading"
          paginated
          backend-pagination
          :total="pagination.total"
          :per-page="pagination.itemsPerPage"
          @page-change="onPageChange"
          checkable
          :checked-rows.sync="selectLinks"
      >
        <b-table-column v-slot="props">
          <n-link :to="'/admin/link/' + props.row.id"
                  class="sm-hover-primary">
            <i class="mdi mdi-pencil"></i>
          </n-link>
        </b-table-column>
        <b-table-column field="img"
                        label="Img"
                        v-slot="props">
          <div class="sm-flex middle left">
            <b-image class="sm-wpx-50"
                     :src="getImageLink(props.row.img)"
                     alt=""
            />
            <div v-if="props.row.img"
                 class="sm-p-1 sm-link sm-ml-2 sm-color-alert"
                 @click="removeImage(props.row.id)">
              <i class="mdi mdi-delete"></i>
            </div>
          </div>
        </b-table-column>
        <b-table-column field="id"
                        label="ID"
                        v-slot="props">
          {{ props.row.id }}
        </b-table-column>
        <b-table-column field="url"
                        label="Url"
                        v-slot="props">
          {{ props.row.url }}
        </b-table-column>
        <b-table-column field="title"
                        label="Title"
                        v-slot="props">
          {{ props.row.title }}
        </b-table-column>
        <b-table-column field="category"
                        label="Category"
                        v-slot="props">
          {{ props.row.category ? props.row.category.name : '' }}
        </b-table-column>
        <b-table-column field="flag"
                        label="Flag"
                        v-slot="props">
          {{ props.row.flag === 1 ? 'Privat' : 'Public' }}
        </b-table-column>
        <b-table-column field="added"
                        label="Added"
                        v-slot="props">
          {{ props.row.added }}
        </b-table-column>
      </b-table>
    </div>
  </section>
</template>

<script>
export default {
  name: "link_index",

  layout: 'admin',

  head() {
    return {
      title: 'Link'
    }
  },

  created() {
    this.getAll(true)
  },

  data() {
    return {
      loading    : false,
      pagination : {
        itemsPerPage: 20,
        total       : 0
      },
      query      : {
        count: 20,
        page : 1
      },
      links      : [],
      selectLinks: []
    }
  },

  methods: {
    /**
     * @param clear
     */
    getAll(clear = false) {
      this.loading = true

      if (clear) {
        this.query.tag = null
      }

      this.$axios.get('/api/adminLinks', {params: this.query})
          .then(response => {
            this.links = response.data.data;

            if (this.query.count) {
              this.pagination.page = parseInt(response.data.meta.current_page);
              this.pagination.itemsPerPage = parseInt(response.data.meta.per_page);
              this.pagination.total = parseInt(response.data.meta.total);
            }
          })
          .catch(() => {
          })
          .finally(() => {
            this.loading = false
          })
    },

    /**
     * @param page
     */
    onPageChange(page) {
      this.query.page = page;
      this.getAll();
    },

    /**
     * @param image
     * @return {null|string}
     */
    getImageLink(image = null) {
      return image ? '/storage/screen/' + image : '/no-image.jpg';
    },

    /**
     * ask rebuild
     */
    askReBuild() {
      if (this.selectLinks.length === 0) {
        this.$buefy.dialog.confirm({
          title      : 'Обновить картинки',
          message    : 'Данная операция может занять много времени',
          confirmText: 'Обновить',
          type       : 'is-danger',
          hasIcon    : true,
          onConfirm  : () => this.reBuildImage()
        })
      } else {
        this.reBuildImage();
      }
    },

    /**
     * reBuildImage
     */
    reBuildImage() {
      this.loading = true

      this.$axios.post('/api/adminLinks/rebuild-img', {ids: this.selectLinks.map(item => item.id)})
          .then(() => {
            this.getAll();
            this.selectLinks = [];
          })
          .catch(() => {
          })
          .finally(() => {
            this.loading = false
          })
    },

    /**
     * @param id
     */
    removeImage(id) {
      this.$buefy.dialog.confirm({
        title      : 'Удалить',
        message    : 'Удалить скрин?',
        confirmText: 'Да',
        type       : 'is-danger',
        hasIcon    : true,
        onConfirm  : () => {
          this.loading = true

          this.$axios.delete('/api/adminLinks/remove-img/' + id)
              .then(() => {
                this.getAll();
                this.selectLinks = [];
              })
              .catch(() => {
              })
              .finally(() => {
                this.loading = false
              });
        }
      })
    }
  }
}
</script>