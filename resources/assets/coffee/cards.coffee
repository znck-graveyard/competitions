$('.card').each(-> $(this).height($(this).width()))

$(window).on('resize', ->
    $('.card').each(->
        $(this).height($(this).width())
    )
)