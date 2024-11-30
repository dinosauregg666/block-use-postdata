import './index.scss'
import {useSelect} from "@wordpress/data"
import {useState, useEffect} from 'react'
import apiFetch from '@wordpress/api-fetch'

wp.blocks.registerBlockType('my-block-use-post/blockusepostdata', {
    title: 'Block use post data',
    icon: 'heart',
    category: 'common',
    attributes: {
        postId: {type: 'string'}
    },
    description: '这是添加这个模块的描述，解释这个模块的作用',
    edit: EditComponent,
    save: function(props) {return null},
});

function EditComponent(props) {
    const [thePreview, setThePreview] = useState('')

    useEffect(() => {
        async function go() {
            const response = await apiFetch({
                path: `/blockusepostdata/v1/getHTML?postId=${props.attributes.postId}`,
                method: 'GET'
            })
            setThePreview(response)
        }
        go()
    }, [props.attributes.postId])

    const allPost = useSelect(select => { // 当数据存储中的文章数据更新时，useSelect 会触发组件重新渲染。
        return select('core').getEntityRecords('postType', 'post', {per_page: -1})
    })
    if(allPost == undefined) return <p>Loading...</p> // 查询需要时间，所以先用这个展示

    return (
        <div>
            <select onChange={e => props.setAttributes({postId: e.target.value})}>
                <option value="">Select a professor</option>
                {
                    allPost.map(pst => {
                        return (
                            <option value={pst.id} selected={props.attributes.postId == pst.id}>
                                {
                                    pst.title.rendered
                                }
                            </option>
                        )
                    })
                }
            </select>

            <div dangerouslySetInnerHTML={{__html: thePreview}}></div>
        </div>

    )
}