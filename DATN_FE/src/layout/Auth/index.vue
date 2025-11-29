<template>
  <div class="auth-layout">
    <div class="auth-left">
      <div class="hero">
        <h1 class="hero-title">Stay on top of time tracking</h1>
        <p class="hero-subtitle">
          Quản lý thời gian thông minh cho học tập và công việc.
        </p>

        <div class="mock-board">
          <div class="board-header"></div>
          <div class="board-grid">
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
          </div>
        </div>
      </div>
    </div>

    <div class="auth-right">
      <div class="auth-container">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
@import "./style.scss";
</style>
