export default (projects, category) => {
    return projects.filter(project => project.categories.indexOf(category) === 0)
}