import firestore from '@/firebase/firestore'

export default async (pageSlug: string) => {
    const collection = firestore.collection('serhii')
    const queryResult = await collection.where('pageSlug', '==', pageSlug).limit(1).get()
    const docData = queryResult.docs.length > 0 ? queryResult.docs[0] : null
    const lastView = new Date()

    if (docData) {
        collection.doc(docData.id).update({ pageSlug, views: docData.get('views') + 1, lastView, })
            .catch(err => console.error(err))
    } else {
        collection.doc(pageSlug).set({ pageSlug, views: 1, lastView })
            .catch(err => console.error(err))
    }
}