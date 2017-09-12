<?php

/* @Twig/Exception/exception.json.twig */
class __TwigTemplate_2ce76927c3507cfdfe713ae7a4a15ba18b027479acfc43667abfd66fa5664607 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_9114e4daf680de851637506b5069eef9b568185b5ea6fe7af2fa077719faa9ab = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_9114e4daf680de851637506b5069eef9b568185b5ea6fe7af2fa077719faa9ab->enter($__internal_9114e4daf680de851637506b5069eef9b568185b5ea6fe7af2fa077719faa9ab_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.json.twig"));

        $__internal_7cf07f62c6ceabef18d42285dcac8b254e61406b96638bdbcc550a04d175f34e = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_7cf07f62c6ceabef18d42285dcac8b254e61406b96638bdbcc550a04d175f34e->enter($__internal_7cf07f62c6ceabef18d42285dcac8b254e61406b96638bdbcc550a04d175f34e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception.json.twig"));

        // line 1
        echo twig_jsonencode_filter(array("error" => array("code" => (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "message" => (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "exception" => $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "toarray", array()))));
        echo "
";
        
        $__internal_9114e4daf680de851637506b5069eef9b568185b5ea6fe7af2fa077719faa9ab->leave($__internal_9114e4daf680de851637506b5069eef9b568185b5ea6fe7af2fa077719faa9ab_prof);

        
        $__internal_7cf07f62c6ceabef18d42285dcac8b254e61406b96638bdbcc550a04d175f34e->leave($__internal_7cf07f62c6ceabef18d42285dcac8b254e61406b96638bdbcc550a04d175f34e_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception.json.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  25 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{{ { 'error': { 'code': status_code, 'message': status_text, 'exception': exception.toarray } }|json_encode|raw }}
", "@Twig/Exception/exception.json.twig", "D:\\xampp\\htdocs\\nasaproj\\vendor\\symfony\\symfony\\src\\Symfony\\Bundle\\TwigBundle\\Resources\\views\\Exception\\exception.json.twig");
    }
}
