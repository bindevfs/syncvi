<template>
    <div class="layout--main navbar-floating footer-static app-page">
        <div id="content-area" class="content-area-reduced">
            <div id="content-overlay"></div>
            <div class="content-wrapper">
                <nav-bar />
                <div class="router-view">
                    <div class="router-content">
                        <div class="content-area__content">
                            <transition name="zoom-fade" mode="out-in">
                                <router-view></router-view>
                            </transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import NavBar from '@/components/NavBar'
export default {
  components: {
    NavBar
  }
}
</script>
