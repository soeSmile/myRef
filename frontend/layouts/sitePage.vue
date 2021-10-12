<template>
  <section class="sm-layout">
    <section class="sm-layout-wrap">
      <header class="sm-layout-header">
        <nav class="sm-nav sm-p-2 sm-bg-white">
          <div class="sm-nav-start"></div>
          <div class="sm-nav-center">
            <n-link class="sm-color-primary sm-p-2 sm-fnt bold"
                    v-for="val in menu"
                    :to="val.link">
              {{ val.name }}
            </n-link>
          </div>
          <div class="sm-nav-end"></div>
        </nav>
      </header>

      <div class="sm-layout-content">
        <nuxt/>
      </div>


      <footer class="sm-layout-footer">
        <nav class="sm-nav sm-p-2 sm-bg-dark">
          <div class="sm-nav-start"></div>
          <div class="sm-nav-center">
            <n-link class="sm-color-white"
                    to="/">
              myRef.com - 2021
            </n-link>
          </div>
          <div class="sm-nav-end"></div>
        </nav>
      </footer>
    </section>
  </section>
</template>

<script>
export default {
  name: "sitePage",

  data() {
    return {
      menu: [
        {name: 'Главная', link: '/'},
        {name: 'Вход', link: '/login'},
        {name: 'Регистрация', link: '/register'},
      ]
    }
  }
}
</script>