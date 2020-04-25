<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Defined Regex
    |--------------------------------------------------------------------------
    |
    | List of predefined regex
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Legend - calc excluded
    |--------------------------------------------------------------------------
    |
    |                   // element relative
    |                   // -------------------------------------------------------------------
    |         'cap'  |  // 1cap = normed height of Capital letters - EXPERIMENTAL
    |         'ch'   |  // 1ch  = width of char '0' (zero, U+0030)
    |         'em'   |  // 1em  = font-size
    |         'ex'   |  // 1ex  = height of char 'x' (often ~0,5em)
    |         'ic'   |  // 1ic  = based on '水' (CJK water ideograph, U+6C34) - EXPERIMENTAL
    |         'lh'   |  // 1lh  = line-height - EXPERIMENTAL
    |         'rem'  |  // 1em  = root font-size
    |         'rlh'  |  // 1rlh = root line-height - EXPERIMENTAL
    |
    |                   // viewport relative
    |                   // -------------------------------------------------------------------
    |         'vh'   |  // 1vh = 1% display height
    |         'vw'   |  // 1vw = 1% display width
    |         'vi'   |  // 1vi = 1% initial containing block (inline axis) - EXPERIMENTAL
    |         'vb'   |  // 1vi = 1% initial containing block (block axis) - EXPERIMENTAL
    |         'vmin' |  // min vh/vw
    |         'vmax' |  // max vh/vw
    |
    |                   // absolute
    |                   // -------------------------------------------------------------------
    |         'px'   |  // 1px = physical pixel
    |         'cm'   |  // centimetre
    |         'mm'   |  // millimetre
    |         'Q'    |  // 1Q = 1/40th of 1cm - EXPERIMENTAL
    |         'in'   |  // inch (1in = 2.54cm)
    |         'pc'   |  // picas (1pc = 12pt)
    |         'pt'      // point (1pt = 1/72in)
    |
    |--------------------------------------------------------------------------
    | Right regular grammar:  Dimension
    |
    | (c) Streetclaw
    |--------------------------------------------------------------------------
    |
    | M := (N, Σ, P, S)
    |
    | N :=  Nonterminal symbols
    | Σ :=  Terminal symbols (disjoint from N)
    | P :=  Production rules
    | S :=  Start symbol
    |
    | /.../ element of Σ := right regular grammar M' (Subset)
    |
    | M = ({ Dimension }
    |      { /unitnumber/, /number/ },
    |      {
    |
    |         /number/       -> ({ Number, Number-ext, Number-ext2, Number-float },
    |                            { startnumber, number, dot },
    |                            {
    |
    |                             Number       -> startnumber Number-ext
    |                             Number-ext   -> number Number-ext
    |                             Number-ext   -> number Number-ext2
    |                             Number-ext   -> number
    |                             Number-ext2  -> dot Number-float
    |                             Number-float -> number Number-float
    |                             Number-float -> number
    |
    |                             startnumber  -> [1-9]
    |                             number       -> [0-9]
    |                             dot          -> '.'
    |
    |                            }, Number)
    |
    |
    |         /unitnumber/   -> ({ Unitnumber, Number-unit },
    |                            { percent-char, unit, /number/ },
    |                            {
    |
    |                            Unitnumber   -> /number/ Number-unit
    |                            Number-unit  -> percent-char
    |                            Number-unit  -> unit
    |
    |                            percent-char -> '%'
    |                            unit         -> (
    |                             'cap'|'ch'|'em'|'ex'|'ic'|'lh'|'rem'|'rlh'|
    |                             'vh'|'vw'|'vi'|'vb'|'vmin'|'vmax'|
    |                             'px'|'cm'|'mm'|'Q'|'in'|'pc'|'pt'
    |                            )
    |
    |                            }, Unitnumber)
    |
    |
    |         Dimension -> /unitnumber/
    |
    |      }, dimension)
    |
    |--------------------------------------------------------------------------
    | Regular expression:  Dimension
    |
    | (c) Streetclaw
    |--------------------------------------------------------------------------
    |
    |  /number/     =  (0|([1-9][0-9]*))(\.(0|[1-9][0-9]*))?
    |
    |  /unitnumber/ =  {{/number/}}(\%|
    |                              cap|ch|em|ex|ic|lh|rem|rlh|
    |                              vh|vw|vi|vb|vmin|vmax|
    |                              px|cm|mm|Q|in|pc|pt)
    |
    |  Dimension    =  {{/unitnumber/}}
    |
    */

    'dimension_regex' => '^(0|([1-9][0-9]*))'.
        '(\.(0|[1-9][0-9]*))?'.
        '(\%|cap|ch|em|ex|ic|lh|rem|rlh|vh|vw|vi|vb|vmin|vmax|px|cm|mm|Q|in|pc|pt)$',

    /*
    |--------------------------------------------------------------------------
    | Right regular grammar:  Color
    |
    | (c) Streetclaw
    |--------------------------------------------------------------------------
    |
    | M := (N, Σ, P, S)
    |
    | N :=  Nonterminal symbols
    | Σ :=  Terminal symbols (disjoint from N)
    | P :=  Production rules
    | S :=  Start symbol
    |
    | /.../ element of Σ := right regular grammar M' (Subset)
    [
    | M = ({ Dimension }
    |      { /unitnumber/, /number/ },
    |      {
    |
    |
    |      }
    |
    |--------------------------------------------------------------------------
    | Regular expression:  Color
    |
    | (c) Streetclaw
    |--------------------------------------------------------------------------
    */

    'color_regex' => '',

];
