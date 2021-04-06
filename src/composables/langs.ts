import { ref } from 'vue'

const langs = ref([
    {
        imageName: "php",
        title: "PHP",
        content: `I'm mostly working with Laravel framework and developing WordPress plugins. Love clean code, types, design patterns, testing and open source.`,
    },
    {
        imageName: "ts",
        title: "TypeScript",
        content: `I always wanted to have a tool that will reduce the amount of bugs in JavaScript. TypeScript is a perfect fit for the that job.`,
    },
    {
        imageName: "go",
        title: "Go lang",
        content: `I've started learning Go lang because I needed fast and strongly typed language for couple of my projects. Go lang was a perfect match for it. But I don't have a lot of experience with Go.`,
    },
])

export default langs