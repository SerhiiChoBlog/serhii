export default tagName => {
    if (tagName === 'database') {
        return '<i class="fas fa-database"></i>'
    }

    return `<i class="fab fa-${tagName}"></i>`
}