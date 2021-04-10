import { ref } from 'vue'

const langs = ref([
    {
        imageName: "php",
        title: "PHP",
        content: `I'm mostly working with Laravel framework and developing WordPress plugins. I have a passion for writing clean, testable code using strict typing.`,
    },
    {
        imageName: "ts",
        title: "TypeScript",
        content: `I always wanted to have a tool that will reduce the amount of bugs in JavaScript. TypeScript is a perfect fit for the that job.`,
    },
    {
        imageName: "go",
        title: "Go",
        content: `I've started learning Go because I needed fast and strongly typed language for couple of my projects. Go was a perfect match for it.`,
    },
])

export default langs