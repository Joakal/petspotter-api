<template>
    <footer>
        <div class="footer">
            <a :href="footer_url">{{footer_text}}</a>
        </div>
    </footer>
</template>

<script>
    export default {
        data() {
            return {
                footer_text: 'Made with ❤️ by Andreas',
                footer_url: 'https://www.linkedin.com/in/amarkauskas/'
            };
        }
    }
</script>
