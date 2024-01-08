<template>
  <div v-if="isShown">
    <button
      @click="copyShortUrl"
      :disabled="isGenerating"
      class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 relative disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent h-9 px-3 text-gray-600 dark:text-gray-400 hover:[&:not(:disabled)]:bg-gray-700/5 dark:hover:[&:not(:disabled)]:bg-gray-950 -ml-1 enabled:bg-gray-700/5 dark:enabled:bg-gray-950"
    >
      <span>Copy Short Filters URL</span>
      <span class="ml-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="inline-block text-gray-400 dark:text-gray-500" role="presentation" width="14" height="20"><path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path><path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path></svg>
      </span>
    </button>

    <span v-if="isGenerating">Generating URL...</span>
  </div>
</template>

<script>
export default {
  props: [
    'card',

    // The following props are only available on resource detail cards...
    // 'resource',
    // 'resourceId',
    // 'resourceName',
  ],

  data: () => ({
    isShown: false,
    isGenerating: false,
    shortenedUrl: '',
  }),

  mounted() {
    this.listenToFiltersChange();
    Nova.$on('filter-changed', this.listenToFiltersChange);
  },

  beforeUnmount() {
    Nova.$off('filter-changed', this.listenToFiltersChange);
  },

  methods: {
    copy() {
      navigator.clipboard.writeText(this.shortenedUrl);

      Nova.success('Copied!')
    },

    async copyShortUrl() {
      if (this.shortenedUrl.trim() !== '') {
        return this.copy();
      }

      await this.generateShortFiltersUrl();

      this.copy();
    },

    async generateShortFiltersUrl() {
      this.isGenerating = true;

      const { data } = await Nova.request().post(
        '/shortened-urls',
        {
          url: window.location.href,
        },
      );

      this.isGenerating = false;

      this.shortenedUrl = data.shortened;
    },

    listenToFiltersChange() {
      const filters = new URLSearchParams(window.location.search).toString();

      this.shortenedUrl = '';

      this.isShown = filters.trim() !== '';
    },
  },
}
</script>
