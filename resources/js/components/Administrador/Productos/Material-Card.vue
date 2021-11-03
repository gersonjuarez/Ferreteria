<template>
  <v-card
    elevation="7"
    v-bind="$attrs"
    class="v-card--material mt-4 pad"
    :color="color2"
  >
    <v-card-title class="align-start">
      <v-sheet
        :color="color"
        :width="fullHeader ? '100%' : undefined"
        class="overflow-hidden mt-n9 transition-swing v-card--material__sheet"
        elevation="6"
        max-width="100%"
        rounded
      >
        <v-theme-provider
          v-if="hasHeading"
          dark
        >
          <div
            v-if="icon"
            :class="iconSmall ? 'pa-7' : 'pa-8'"
          >
            <v-icon
              :large="!iconSmall"
              v-text="icon"
            />
          </div>

          <slot name="heading" style="width:100%" />

          <div
            v-if="heading"
           
          >
            {{ heading }}
          </div>
        </v-theme-provider>
      </v-sheet>

      <div
        v-if="hasTitle"
        :class="fullHeader ? 'pt-4' : 'pl-3'"
        class="text-h4 v-card--material__title"
      >
        <slot name="title" />

        <template v-if="title">
          {{ title }}
        </template>

        <div class="text-subtitle-1 mb-n4">
          <slot name="subtitle" />

          <template v-if="subtitle">
            {{ subtitle }}
          </template>
        </div>
      </div>
    </v-card-title>

    <slot />

    <template v-if="$slots.actions">
      <v-divider class="mt-2 mx-4" />

      <v-card-actions class="px-4 text-caption grey--text">
        <slot name="actions" />
      </v-card-actions>
    </template>
  </v-card>
</template>

<script>
  export default {
    name: 'MaterialCard',

    props: {
      color: String,
      color2: String,
      fullHeader: Boolean,
      heading: String,
      icon: String,
      iconSmall: Boolean,
      subtitle: String,
      title: String,
    },

    computed: {
      hasHeading () {
        return !!(
          this.icon ||
          this.heading ||
          this.$slots.heading
        )
      },
      hasTitle () {
        return !!(
          this.title ||
          this.subtitle ||
          this.$slots.title ||
          this.$slots.subtitle
        )
      },
    },
  }
</script>

<style scoped>
.pad{

margin: 1em;
top: 1em;


}
</style>
