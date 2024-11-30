import './index.scss'
import {useSelect} from "@wordpress/data"

import React from 'react'

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
        </div>
    )
}