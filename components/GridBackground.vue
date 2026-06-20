<template>
  <div class="grid-background">
    <div class="grid-lines"></div>
    <div class="grid-dots"></div>
    <div class="grid-glow"></div>
  </div>
</template>

<script>
export default {
  name: 'GridBackground'
}
</script>

<style scoped>
.grid-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  overflow: hidden;
}

.grid-lines {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #ffffff;
  background-image:
    linear-gradient(rgba(0, 255, 17, 0.06) 1px, transparent 1px),
    linear-gradient(90deg, rgba(0, 255, 17, 0.06) 1px, transparent 1px);
  background-size: 60px 60px;
  animation: gridMove 20s linear infinite;
}

.grid-dots {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: radial-gradient(circle, rgba(0, 255, 17, 0.3) 1.5px, transparent 1.5px);
  background-size: 60px 60px;
  animation: dotPulse 4s ease-in-out infinite;
}

.grid-glow {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background:
    radial-gradient(ellipse at 20% 50%, rgba(0, 255, 17, 0.03) 0%, transparent 50%),
    radial-gradient(ellipse at 80% 20%, rgba(0, 255, 17, 0.03) 0%, transparent 50%),
    radial-gradient(ellipse at 50% 80%, rgba(0, 255, 17, 0.02) 0%, transparent 50%);
  animation: glowShift 8s ease-in-out infinite alternate;
}

@keyframes gridMove {
  0% { transform: translate(0, 0); }
  100% { transform: translate(60px, 60px); }
}

@keyframes dotPulse {
  0%, 100% { opacity: 0.5; }
  50% { opacity: 1; }
}

@keyframes glowShift {
  0% { transform: scale(1) translate(0, 0); }
  100% { transform: scale(1.1) translate(-30px, -30px); }
}
</style>
