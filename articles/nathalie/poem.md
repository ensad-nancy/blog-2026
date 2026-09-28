---
title: internetg111rl: poem
date: 2026-09-28
tags: poem
preview: 
---

# Lights

October comes

Can’t find somebody

Car lights come…

Exciting, sexy, fun –


	lust


… and goes.


	One-night stands.



November comes

Somebody different

Completely different


Car lights come…

Careful, smooth, kind –


	love


… and goes.


	Lovelorn.



October, November, 

Exciting, Careful,

Sexy, Smooth, 

Fun, Kind,


One-night stands,

Lovelorn.


Goes and goes.



	Can’t find somebody completely different. 



Acteur, Stories,

Stories, Actress,

Acteur, Stories,

Stories, Actress.


	Lights.


Comes and goes.




import { useState } from 'react'
import { Editor, Inputs, styled } from '@compai/css-gui'

export const MyEditor = () => {
  const [styles, setStyles] = useState({
    fontSize: { value: 16, unit: 'px' },
    lineHeight: { value: 1.4, unit: 'number' },
    color: 'tomato',
  })

  return (
    <>
      <Editor styles={styles} onChange={setStyles}>
        <Inputs.FontSize />
        <Inputs.LineHeight />
        <Inputs.Color />
        <Fieldset type="pseudo-element" name="first-letter">
          <Inputs.FontSize />
          <Inputs.FontWeight />
          <Inputs.Color />
        </Fieldset>
      </Editor>
      <styled.p styles={styles}>Hello, world!</styled.p>
    </>
  )
}