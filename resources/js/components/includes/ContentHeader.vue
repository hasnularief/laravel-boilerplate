<template>
    <section class="content-header">
      <h1>
        {{title}}
        <small>{{subtitle}}</small>
      </h1>
      <ol v-if="breadcrumb" class="breadcrumb">
        <li><a href="#"><i v-if="breadcrumb.icon" :class="breadcrumb.icon"></i> {{breadcrumb.path[0]}}</a></li>
        <li><a href="#">{{breadcrumb.path[1]}}</a></li>
        <li class="active">{{breadcrumb.path[2]}}</li>
      </ol>
    </section>
</template>

<script>
    export default {
      props: {
        title: {
          type: String
        },
        subtitle: {
          type: String
        },
        breadcrumb: {
          type: Object
        }
      }        
    }
</script>
